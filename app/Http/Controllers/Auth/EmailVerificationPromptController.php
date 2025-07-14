<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

// =============================
// Controller untuk tampilkan halaman prompt verifikasi email
// Berisi: tampilkan halaman yang meminta user untuk verifikasi email
// =============================

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     * Tampilkan halaman yang meminta user untuk verifikasi email
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-email');
    }
}
