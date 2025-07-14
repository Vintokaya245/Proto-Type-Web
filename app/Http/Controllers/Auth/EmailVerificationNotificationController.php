<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// =============================
// Controller untuk kirim ulang notifikasi verifikasi email
// Berisi: kirim ulang email verifikasi jika user belum verifikasi
// =============================

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     * Kirim ulang email verifikasi ke user
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
