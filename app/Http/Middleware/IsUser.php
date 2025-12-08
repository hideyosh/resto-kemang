<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            // Jika belum login, redirect ke login
            return redirect('/login');
        }

        // Cek apakah role user adalah 'user' (bukan admin)
        if (auth()->user()->role !== 'user') {
            // Jika bukan user biasa, kembalikan error 403
            abort(403, 'Anda tidak memiliki akses untuk halaman ini');
        }

        // Jika adalah user biasa, lanjutkan request
        return $next($request);
    }
}
