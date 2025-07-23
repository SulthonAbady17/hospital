<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationStatusChanged;
use App\Models\Application;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = auth()->user()->applications()->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List semua pendaftaran',
            'data' => $applications->map(function ($application) {
                return [
                    'id' => $application->id,
                    'status' => $application->status,
                    'surat_rujukan' => Storage::url($application->referral_letter_path),
                    'tanggal' => $application->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $validator = Validator::make($request->all(), [
            'referral_letter' => 'required|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dikirim, mohon tunggu verifikasi',
            'data' => $application
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran tidak ditemukan.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Detail Pendaftaran',
            'data' => $application
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $validator = Validator::make($request->all(), [
            'referral_letter' => 'required|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil diperbarui.',
            'data' => $application
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran tidak ditemukan.'
            ], 404);
        }

        try {
            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dihapus!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, app$application gagal dihapus!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
