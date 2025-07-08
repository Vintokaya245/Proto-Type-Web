<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ArsipController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $arsipCount = \App\Models\Arsip::count();
    return view('dashboard', compact('arsipCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk Periode dan Arsip
    Route::resource('periode', PeriodeController::class);
    Route::resource('arsip', ArsipController::class);
});

require __DIR__.'/auth.php';
