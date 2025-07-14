<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// =============================
// Middleware Admin - Mengatur akses khusus admin
// Berisi: pengecekan role admin, redirect jika bukan admin
// =============================

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Cek apakah user yang login adalah admin
     * Jika bukan admin, redirect ke halaman 403 (Unauthorized)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN memiliki role admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            // Jika bukan admin, tampilkan halaman error 403
            abort(403, 'Unauthorized action.');
        }

        // Jika admin, lanjutkan ke halaman yang diminta
        return $next($request);
    }
}
