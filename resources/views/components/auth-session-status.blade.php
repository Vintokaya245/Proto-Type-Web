{{--
    Komponen untuk menampilkan status session (misal: login sukses, logout, dsb)
--}}

@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
@endif
