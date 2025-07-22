<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->role) {
                case 'patient':
                    return redirect()->intended(route('patient.dashboard'));
                case 'v1':
                    return redirect()->intended(route('verifier1.dashboard'));
                case 'v2':
                    return redirect()->intended(route('verifier2.dashboard'));
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'));
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['email' => 'Peran pengguna tidak valid.']);
            }
        }
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }
}
