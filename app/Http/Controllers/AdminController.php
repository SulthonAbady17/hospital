<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Penting: Untuk berinteraksi dengan tabel users
use Illuminate\Support\Facades\Hash; // Untuk mengenkripsi password
use Illuminate\Support\Str; // Untuk membuat string acak (token verifikasi)
use Illuminate\Support\Facades\Mail; // Untuk mengirim email
use App\Mail\AccountVerificationMail; // Mailable yang akan kita buat nanti
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = \App\Models\User::all();

        return view('admin.dashboard', compact('user', 'users'));
    }

    public function createUserForm()
    {
        return view('admin.create_user');
    }

    public function storeUser(Request $request)
    {
        // 1. Validasi Data Input
        // Laravel akan otomatis mengarahkan kembali ke form dengan error jika validasi gagal.
        $request->validate([
            'name' => 'required|string|max:255', // Nama wajib diisi, string, maks 255 karakter
            'email' => 'required|string|email|max:255|unique:users', // Email wajib, string, format email, maks 255, dan HARUS UNIK di tabel users
            'password' => 'required|string|min:8|confirmed', // Password wajib, string, minimal 8 karakter, dan harus cocok dengan 'password_confirmation'
            'role' => 'required|in:patient,v1,v2,admin', // Peran wajib, dan harus salah satu dari nilai yang diizinkan
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Penting: Hash password sebelum disimpan!
            'role' => $request->role,
            'email_verified_at' => null, // Set null karena akun baru belum diverifikasi
            // 'verification_token' => $verificationToken, // Simpan token verifikasi
        ]);

        // dd($user->verification_token);

        try {
            // Mengirim email menggunakan Mailable AccountVerificationMail
            // Mailable ini akan menerima objek $user sebagai parameter
            // Mail::to($user->email)->send(new AccountVerificationMail($user));
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            // Jika terjadi error saat mengirim email (misal: konfigurasi SMTP salah)
            // Log error untuk debugging
            // Log::error('Gagal mengirim email verifikasi ke ' . $user->email . ': ' . $e->getMessage());
            // Arahkan kembali dengan pesan error yang informatif
            // return back()->with('error', 'Akun berhasil dibuat, tetapi gagal mengirim email verifikasi. Silakan coba lagi nanti atau hubungi dukungan.');
            Log::error('Gagal mengirim email verifikasi ke ' . $user->email . ': ' . $e->getMessage());
            return back()->with('error', 'Akun berhasil dibuat, tetapi gagal mengirim email verifikasi. Silakan coba lagi nanti atau hubungi dukungan.');
        }
        // 5. Redirect dengan Pesan Sukses
        // Arahkan kembali ke dashboard admin dengan pesan sukses yang akan ditampilkan di view.
        return redirect()->route('admin.dashboard')->with('success', 'Akun ' . $user->name . ' (' . $user->role . ') berhasil dibuat. Email verifikasi telah dikirim.');
    }
}
