<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// =============================
// Controller untuk manajemen Session Login/Logout
// Berisi: tampilkan form login, proses login, logout
// =============================

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * Proses login user dengan email dan password
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ganti redirect ke dashboard tanpa RouteServiceProvider
        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     * Proses logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
