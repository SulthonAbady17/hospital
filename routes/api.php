<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::prefix('patients')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('patients.index');
    Route::post('/', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/{application}', [PatientController::class, 'show'])->name('patients.show');
    Route::put('/{application}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/{application}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
