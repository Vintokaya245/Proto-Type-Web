<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periodes = Periode::all();
        $query = Arsip::with('periode');
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }
        if ($request->has('q') && trim($request->q) !== '') {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                     ->orWhere('description', 'like', "%$q%")
                     ->orWhere('kurun_waktu', 'like', "%$q%")
                     ->orWhere('jumlah', 'like', "%$q%")
                     ->orWhere('box', 'like', "%$q%")
                     ;
            });
        }
        $arsip = $query->paginate(10)->withQueryString();
        return view('arsip.index', compact('arsip', 'periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periodes = Periode::all();
        return view('arsip.create', compact('periodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'periode_id' => 'required|exists:periode,id',
            'description' => 'nullable|string',
            'kurun_waktu' => 'nullable|string',
            'jumlah' => 'nullable|string',
            'box' => 'nullable|string'
        ]);

        $data = $request->only(['name', 'periode_id', 'description', 'kurun_waktu', 'jumlah', 'box']);
        Arsip::create($data);
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Arsip $arsip)
    {
        return view('arsip.show', compact('arsip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arsip $arsip)
    {
        $periodes = Periode::all();
        return view('arsip.edit', compact('arsip', 'periodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Arsip $arsip)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'periode_id' => 'required|exists:periode,id',
            'description' => 'nullable|string',
            'kurun_waktu' => 'nullable|string',
            'jumlah' => 'nullable|string',
            'box' => 'nullable|string'
        ]);

        $data = $request->only(['name', 'periode_id', 'description', 'kurun_waktu', 'jumlah', 'box']);
        $arsip->update($data);
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arsip $arsip)
    {
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil dihapus!');
    }
}
