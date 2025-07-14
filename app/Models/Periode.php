<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// =============================
// Model Periode - Menangani data periode arsip
// Berisi: relasi ke arsip, field yang bisa diisi, dll.
// =============================

class Periode extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'periode';

    // Field yang bisa diisi secara massal (mass assignment)
    protected $fillable = [
        'name'    // Nama periode (contoh: 2020, 2021, dll.)
    ];

    /**
     * Relasi ke model Arsip (One-to-Many)
     * Satu periode bisa memiliki banyak arsip
     */
    public function arsip()
    {
        return $this->hasMany(Arsip::class);
    }
}
