<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

// =============================
// Request class untuk validasi dan autentikasi login
// Berisi: validasi form login, rate limiting, autentikasi user
// =============================

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Cek apakah user berhak melakukan request ini
     */
    public function authorize(): bool
    {
        return true;  // Semua user boleh melakukan request login
    }

    /**
     * Get the validation rules that apply to the request.
     * Aturan validasi untuk form login
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],    // Email wajib, string, format email valid
            'password' => ['required', 'string'],           // Password wajib, string
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     * Mencoba autentikasi user dengan email dan password
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        // Cek rate limiting (mencegah brute force)
        $this->ensureIsNotRateLimited();

        // Coba login dengan email dan password
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Jika gagal, hitung percobaan login
            RateLimiter::hit($this->throttleKey());

            // Throw error dengan pesan gagal login
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Jika berhasil, clear rate limiting
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     * Cek apakah request login tidak melebihi batas percobaan
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Cek apakah percobaan login tidak melebihi 5 kali
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Jika melebihi batas, trigger event lockout
        event(new Lockout($this));

        // Hitung waktu tunggu sebelum bisa login lagi
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Throw error dengan pesan rate limiting
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     * Generate key untuk rate limiting berdasarkan email dan IP
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
