<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('periode_id')->constrained('periode')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('kurun_waktu')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('box')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
}; 