<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =============================
// Migration untuk membuat tabel arsip
// Berisi: struktur tabel arsip dengan relasi ke periode
// =============================

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel arsip dengan struktur kolom yang diperlukan
     */
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();                                    // Primary key auto increment
            $table->string('name');                          // Nama/jenis arsip
            $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade');  // Foreign key ke tabel periode
            $table->text('description')->nullable();         // Deskripsi arsip (opsional)
            $table->string('kurun_waktu')->nullable();       // Kurun waktu arsip (opsional)
            $table->string('jumlah')->nullable();            // Jumlah arsip (opsional)
            $table->string('box')->nullable();               // Nomor box penyimpanan (opsional)
            $table->timestamps();                            // Created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel arsip jika migration di-rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
}; 