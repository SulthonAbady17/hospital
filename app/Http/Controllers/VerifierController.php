<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifierController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $v1_applications = Application::where('status', 'pending_v1')->latest()->get();
        $v2_applications = Application::where('status', 'pending_v2')->latest()->get();

        return view('verifier.dashboard', compact('user', 'v1_applications', 'v2_applications'));
    }
}
