<?php

use App\Http\Controllers\Api\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [PatientController::class, 'index'])
    ->name('patients.index');
