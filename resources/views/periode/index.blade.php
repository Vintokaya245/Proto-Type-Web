@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Periode</h2>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('periode.create') }}" class="btn btn-success">Tambahkan Periode</a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            @if(auth()->user()->role === 'admin')
                            <th class="text-end">Tindakan</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periodes as $periode)
                        <tr>
                            <td>{{ $periode->name }}</td>
                            @if(auth()->user()->role === 'admin')
                            <td class="text-end">
                                <a href="{{ route('periode.edit', $periode->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('periode.destroy', $periode->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this periode?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4">Tidak ada data periode.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 