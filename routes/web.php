<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VerifierController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // Pastikan view ini ada
})->middleware('guest');


Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.send.otp');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.otp');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Rute untuk Pasien
Route::middleware(['auth', 'role:patient', 'verified'])->prefix('patient')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
    Route::prefix('applications')->group(function () {
        Route::get('/create', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('/', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/{application}', [ApplicationController::class, 'update'])->name('applications.update');
        Route::delete('/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    });
});

// Rute untuk Verifikator
// Anda bisa membedakan verifikator1 dan verifikator2 jika perlu,
// tapi untuk dashboard awal, kita bisa gabungkan dulu.
Route::middleware(['auth', 'role:v1'])->prefix('verifikator1', 'verified')->group(function () {
    Route::get('/dashboard', [VerifierController::class, 'index'])->name('verifier1.dashboard');
    Route::post('/applications/{application}/verify-v1', [ApplicationController::class, 'verifyV1'])->name('applications.verify.v1');
});
Route::middleware(['auth', 'role:v2'])->prefix('verifikator2', 'verified')->group(function () {
    Route::get('/dashboard', [VerifierController::class, 'index'])->name('verifier2.dashboard');
    Route::post('/applications/{application}/verify-v2', [ApplicationController::class, 'verifyV2'])->name('applications.verify.v2');
});

Route::middleware(['auth'])->prefix('applications')->group(function () {
    Route::get('/{application}/reject', [ApplicationController::class, 'rejectForm'])->name('applications.reject.form');
    Route::post('/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
});

// Rute untuk Admin
Route::middleware(['auth', 'role:admin', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUserForm'])->name('admin.users.create');
    Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.users.store');
});
// Rute untuk halaman yang tidak memiliki akses (jika redirect dari middleware)
Route::get('/unauthorized', function () {
    return view('unauthorized'); // Buat view ini
})->name('unauthorized');
