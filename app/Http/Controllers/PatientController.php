<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $applications = Auth::user()->applications()->latest()->get();
        return view('patient.dashboard', compact('applications'));
    }
}
