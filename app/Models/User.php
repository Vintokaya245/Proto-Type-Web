<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// =============================
// Model User - Menangani data pengguna sistem
// Berisi: autentikasi, role, relasi, dll.
// =============================

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Field yang bisa diisi secara massal (mass assignment)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',      // Nama lengkap user
        'email',     // Email user (untuk login)
        'password',  // Password user (terenkripsi)
        'role',      // Role user (admin/user)
    ];

    /**
     * Field yang disembunyikan saat serialisasi
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',        // Password tidak boleh ditampilkan
        'remember_token',  // Token remember login
    ];

    /**
     * Tipe data untuk field tertentu
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',  // Email verification timestamp
        'password' => 'hashed',             // Password di-hash otomatis
    ];

    /**
     * Cek apakah user adalah admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
