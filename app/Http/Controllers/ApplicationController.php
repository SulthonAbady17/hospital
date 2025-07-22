<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationStatusChanged;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'referral_letter' => 'required|mimes:pdf|max:2048',
        ]);

        // Simpan file surat rujukan
        $file = $request->file('referral_letter');
        $fileName = $file->hashName();
        $filePath = $file->storeAs('referral_letters', $fileName, 'public');

        // Buat aplikasi baru
        $application = new Application();
        $application->user_id = Auth::id();
        $application->referral_letter_path = $filePath;
        $application->status = 'pending_v1';
        $application->save();
        // Kirim notifikasi email ke pasien
        Mail::to($application->user->email)->send(
            new ApplicationStatusChanged('Pendaftaran Anda telah diterima', $application->status, $application->rejection_reason, $application->updated_at)
        );
        return redirect()->route('patient.dashboard')
            ->with('success', 'Pendaftaran berhasil dikirim, mohon tunggu verifikasi');
    }

    // Menampilkan form untuk mengedit permohonan
    public function edit(Application $application)
    {
        // Pastikan pengguna hanya bisa mengedit permohonan miliknya
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('applications.edit', compact('application'));
    }

    // Memperbarui permohonan
    public function update(Request $request, Application $application)
    {
        // Validasi input
        $request->validate([
            'referral_letter' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Jika ada file baru, simpan dan update path
        if ($request->hasFile('referral_letter')) {
            // Hapus file lama jika ada
            if ($application->referral_letter_path) {
                Storage::delete($application->referral_letter_path);
            }

            // Simpan file baru
            $filePath = $request->file('referral_letter')->store('referral_letters', 'public');
            $application->referral_letter_path = $filePath;
        }

        // Simpan perubahan lainnya jika diperlukan
        $application->save();

        return redirect()->route('patient.dashboard')->with('success', 'Permohonan berhasil diperbarui.');
    }

    // Menghapus permohonan
    public function destroy(Application $application)
    {
        // Pastikan pengguna hanya bisa menghapus permohonan miliknya
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file surat rujukan jika ada
        if ($application->referral_letter_path) {
            Storage::delete($application->referral_letter_path);
        }

        // Hapus permohonan dari database
        $application->delete();

        return redirect()->route('patient.dashboard')->with('success', 'Permohonan berhasil dihapus.');
    }


    public function verifyV1(Application $application)
    {
        $application->status = 'pending_v2';
        $application->save();
        // Kirim notifikasi ke pasien
        Mail::to($application->user->email)->send(
            new ApplicationStatusChanged('Pendaftaran Anda telah lolos verifikasi tahap 1', $application->status, null, $application->updated_at)
        );
        return back()->with('success', 'Aplikasi berhasil diverifikasi oleh Verifikator 1');
    }

    public function verifyV2(Application $application)
    {
        $application->status = 'approved';
        $application->save();
        // Kirim notifikasi ke pasien
        Mail::to($application->user->email)->send(
            new ApplicationStatusChanged('Pendaftaran Anda telah disetujui', $application->status, null, $application->updated_at)
        );
        return back()->with('success', 'Aplikasi berhasil diverifikasi oleh Verifikator 2');
    }

    public function rejectForm(Application $application)
    {
        return view('applications.reject', compact('application'));
    }

    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);
        $application->status = 'rejected';
        $application->rejection_reason = $request->rejection_reason;
        $application->save();
        // Kirim notifikasi penolakan ke pasien
        Mail::to($application->user->email)->send(
            new ApplicationStatusChanged('Pendaftaran Anda ditolak', $application->status, $application->rejection_reason, $application->updated_at)
        );
        return back()->with('success', 'Aplikasi berhasil ditolak');
    }
}
