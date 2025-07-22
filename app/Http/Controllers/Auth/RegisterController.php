<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'patient',
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        Auth::login($user);

        switch ($user->role) {
            case 'patient':
                return redirect()->intended(route('patient.dashboard'));
            case 'verifikator1':
                return redirect()->intended(route('verifier1.dashboard'));
            case 'verifikator2':
                return redirect()->intended(route('verifier2.dashboard'));
            case 'admin':
                return redirect()->intended(route('admin.dashboard'));
            default:
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Peran pengguna tidak valid.']);
        }
    }
}
