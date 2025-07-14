{{--
    Halaman utama daftar arsip
    Berisi:
    - Filter & pencarian arsip
    - Tabel data arsip
    - Tombol tambah, edit, hapus, download Excel
--}}

@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header & tombol tambah arsip - Hanya admin yang bisa tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Arsip</h2>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('arsip.create') }}" class="btn btn-success">Tambahkan Data</a>
        @endif
    </div>

    {{-- Notifikasi sukses - Menampilkan pesan setelah operasi CRUD --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form filter & pencarian arsip - Filter berdasarkan periode dan pencarian global --}}
    <form method="GET" action="" class="mb-3 d-flex align-items-center gap-2">
        <label for="periode_id" class="me-2 mb-0">Filter Periode:</label>
        <select name="periode_id" id="periode_id" class="form-select w-auto me-2" onchange="this.form.submit()">
            <option value="">Semua Periode</option>
            @foreach($periodes as $periode)
                <option value="{{ $periode->id }}" {{ request('periode_id') == $periode->id ? 'selected' : '' }}>{{ $periode->name }}</option>
            @endforeach
        </select>
        <input type="text" name="q" class="form-control w-auto" placeholder="Cari arsip..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
        {{-- Tombol download Excel dengan filter periode --}}
        <a href="{{ route('arsip.downloadExcel', array_filter(['periode_id' => request('periode_id')])) }}" class="btn btn-success btn-sm ms-2">
            Download Excel
        </a>
    </form>

    {{-- Script untuk auto-submit form saat input pencarian dikosongkan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="q"]');
            const form = searchInput.closest('form');
            let lastValue = searchInput.value;
            searchInput.addEventListener('input', function() {
                if (this.value === '' && lastValue !== '') {
                    form.submit();
                }
                lastValue = this.value;
            });
        });
    </script>

    {{-- Tabel data arsip - Menampilkan data dalam format tabel --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    {{-- Header tabel dengan warna hijau --}}
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Berkas/jenis Arsip</th>
                            <th>Kurun/Waktu</th>
                            <th>Jumlah</th>
                            <th>Box</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data arsip --}}
                        @forelse($arsip as $index => $arsipItem)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $arsipItem->name }}</td>
                            <td>{{ $arsipItem->kurun_waktu }}</td>
                            <td>{{ $arsipItem->jumlah }}</td>
                            <td>{{ $arsipItem->box }}</td>
                            <td>{{ $arsipItem->description }}</td>
                            <td class="text-center">
                                {{-- Tombol edit dan delete - Hanya admin yang bisa edit/delete --}}
                                <a href="{{ route('arsip.edit', $arsipItem->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('arsip.destroy', $arsipItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this arsip?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        {{-- Pesan jika tidak ada data arsip --}}
                        <tr>
                            <td colspan="7" class="text-center py-4">Belum ada data arsip.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Pagination - Navigasi halaman data --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $arsip->links() }}
    </div>
</div>
@endsection 