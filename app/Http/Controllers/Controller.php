<?php

// =============================
// Base Controller (parent) untuk semua controller lain
// Bisa digunakan untuk fungsi global yang dipakai banyak controller
// =============================

namespace App\Http\Controllers;

abstract class Controller
{
    // Fungsi untuk dashboard (jika diperlukan)
    // public function dashboard() {
    //     $arsipCount = \App\Models\Arsip::count();
    //     return view('dashboard', compact('arsipCount'));
    // }
}
