<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// =============================
// Controller untuk manajemen Periode Arsip
// Berisi fitur: list, tambah, edit, hapus periode
// =============================

class PeriodeController extends Controller
{
    /**
     * Menampilkan daftar periode
     */
    public function index()
    {
        $periodes = Periode::all();
        return view('periode.index', compact('periodes'));
    }

    /**
     * Menampilkan form tambah periode
     */
    public function create()
    {
        return view('periode.create');
    }

    /**
     * Simpan data periode baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        Periode::create($request->only('name'));
        return redirect()->route('periode.index')->with('success', 'Periode berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail periode (jika ada)
     */
    public function show(Periode $periode)
    {
        return view('periode.show', compact('periode'));
    }

    /**
     * Tampilkan form edit periode
     */
    public function edit(Periode $periode)
    {
        return view('periode.edit', compact('periode'));
    }

    /**
     * Update data periode di database
     */
    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $periode->update($request->only('name'));
        return redirect()->route('periode.index')->with('success', 'Periode berhasil diupdate!');
    }

    /**
     * Hapus data periode dari database
     */
    public function destroy(Periode $periode)
    {
        $periode->delete();
        return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus!');
    }
}
