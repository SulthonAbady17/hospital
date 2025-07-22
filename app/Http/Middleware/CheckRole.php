<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login'); // Arahkan ke halaman login jika belum login
        }

        $user = Auth::user();
        // Periksa apakah peran pengguna sesuai dengan peran yang diizinkan
        if ($user->role == $role) {
            return $next($request);
        }
        // Jika peran tidak sesuai, arahkan ke halaman yang tidak diizinkan atau dashboard
        // Anda bisa menyesuaikan ini, misalnya ke 403 Forbidden atau dashboard default
        return redirect()->route('unauthorized')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
