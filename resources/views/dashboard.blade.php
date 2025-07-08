<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-white mb-4" style="background-color: #e74c3c;">
                                <div class="card-body">
                                    <h2 class="fw-bold" style="font-size:2.5rem;">{{ $arsipCount }} Arsip</h2>
                                    <div>Data Arsip</div>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <a href="{{ route('arsip.index') }}" class="btn btn-light btn-sm">
                                        Lihat data <span>&#8594;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 