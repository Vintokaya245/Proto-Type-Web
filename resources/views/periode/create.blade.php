{{--
    Halaman tambah data periode arsip
    Berisi:
    - Form input data periode baru
    - Validasi dan notifikasi error
--}}

@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Form tambah data periode --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-success fw-bold mb-4">Menambahkan Periode Baru</h2>

                    <form action="{{ route('periode.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Periode</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('periode.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-success px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 