<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // --- Langkah 1: Kirim OTP ke Email ---
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        // Hapus OTP lama yang belum digunakan untuk email ini
        Otp::where('email', $email)->where('is_used', false)->delete();
        // Generate OTP (misal: 6 digit angka)
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(5); // OTP berlaku 5 menit
        // Simpan OTP ke tabel otps
        Otp::create([
            'email' => $email,
            'otp_code' => $otpCode,
            'expires_at' => $expiresAt,
        ]);
        // Kirim OTP via email
        // Anda perlu membuat Mailable class untuk ini
        Mail::to($email)->send(new OtpMail($otpCode, $expiresAt));

        return redirect()->route('password.otp.form')->with('email', $email)->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showOtpForm(Request $request)
    {
        // Pastikan ada email yang dikirim dari langkah sebelumnya
        if (!$request->session()->has('email')) {
            return redirect()->route('password.forgot')->with('error', 'Silakan masukkan email Anda terlebih dahulu.');
        }
        $email = $request->session()->get('email');
        return view('auth.verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|string|digits:6',
        ]);
        $otp = Otp::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->where('is_used', false)
            ->first();
        if (!$otp) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.'])->withInput();
        }
        if ($otp->isExpired()) {
            $otp->update(['is_used' => true]); // Tandai sebagai expired/used
            return back()->withErrors(['otp_code' => 'Kode OTP telah kadaluarsa.'])->withInput();
        }

        // OTP valid, tandai sebagai sudah digunakan
        $otp->update(['is_used' => true]);
        // Simpan email di session untuk langkah reset password
        $request->session()->put('verified_email_for_reset', $request->email);
        return redirect()->route('password.reset.form')->with('success', 'Kode OTP berhasil diverifikasi. Silakan atur password baru Anda.');
    }

    public function showResetForm(Request $request)
    {
        // Pastikan email sudah diverifikasi melalui OTP
        if (!$request->session()->has('verified_email_for_reset')) {
            return redirect()->route('password.forgot')->with('error', 'Anda harus memverifikasi OTP terlebih dahulu.');
        }
        $email = $request->session()->get('verified_email_for_reset');
        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // Pastikan email yang digunakan sama dengan yang diverifikasi OTP
        if ($request->email !== $request->session()->get('verified_email_for_reset')) {
            return redirect()->route('password.forgot')->with('error', 'Terjadi kesalahan. Silakan mulai proses reset password dari awal.');
        }
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        // Hapus session verifikasi email
        $request->session()->forget('verified_email_for_reset');
        return redirect()->route('login')->with('success', 'Password Anda berhasil diubah. Silakan login dengan password baru.');
    }
}
