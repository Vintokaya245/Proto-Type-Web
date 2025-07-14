<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// =============================
// Model Arsip - Menangani data arsip statis
// Berisi: relasi ke periode, field yang bisa diisi, dll.
// =============================

class Arsip extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'arsip';

    // Field yang bisa diisi secara massal (mass assignment)
    protected $fillable = [
        'name',           // Nama/jenis arsip
        'periode_id',     // ID periode (foreign key)
        'description',     // Deskripsi arsip
        'kurun_waktu',    // Kurun waktu arsip
        'jumlah',         // Jumlah arsip
        'box'             // Nomor box penyimpanan
    ];

    /**
     * Relasi ke model Periode (Many-to-One)
     * Satu arsip hanya bisa memiliki satu periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
