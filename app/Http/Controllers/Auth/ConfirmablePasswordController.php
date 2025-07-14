<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

// =============================
// Controller untuk konfirmasi password user
// Berisi: tampilkan form konfirmasi password dan proses konfirmasi
// =============================

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     * Tampilkan halaman konfirmasi password
     */
    public function show()
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     * Proses konfirmasi password user sebelum aksi sensitif
     */
    public function store(Request $request)
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
