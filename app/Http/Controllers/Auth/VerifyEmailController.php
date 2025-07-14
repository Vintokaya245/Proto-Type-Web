<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// =============================
// Controller untuk verifikasi email user
// Berisi: proses verifikasi email setelah user klik link di email
// =============================

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     * Tandai email user sebagai terverifikasi setelah klik link di email
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
