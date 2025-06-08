<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role admin (role = 1)
        if (Auth::check() && Auth::user()->role == 1) {
            return $next($request); // Lanjut ke halaman admin
        }

        // Jika bukan admin, redirect dengan pesan
        Alert::toast('Kamu bukan admin!', 'error');
        return redirect('/'); // Atau redirect ke halaman login umum
    }
}
