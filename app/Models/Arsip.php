<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';

    protected $fillable = [
        'name',
        'periode_id',
        'description',
        'kurun_waktu',
        'jumlah',
        'box'
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
