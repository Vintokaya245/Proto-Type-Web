<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =============================
// Migration untuk membuat tabel periode
// Berisi: struktur tabel periode untuk pengelompokan arsip
// =============================

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel periode dengan struktur kolom yang diperlukan
     */
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id();                    // Primary key auto increment
            $table->string('name');          // Nama periode (contoh: 2020, 2021, dll.)
            $table->text('description')->nullable();  // Deskripsi periode (opsional)
            $table->timestamps();            // Created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel periode jika migration di-rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
}; 