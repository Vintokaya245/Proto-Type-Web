<!--
    Layout utama untuk halaman aplikasi setelah login
    Berisi struktur HTML dasar, import CSS/JS, navbar, header, dan slot konten utama
-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard CRUD Arsip</title>

        <!-- Bootstrap CSS - Framework CSS untuk styling -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom CSS - Styling khusus aplikasi -->
        <style>
            body {
                background-color: #f8f9fa;
            }
            .btn-success {
                background-color: #00A000;
                border-color: #009000;
            }
            .btn-success:hover {
                background-color: #008000;
                border-color: #007000;
            }
            .card {
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                border: none;
                border-radius: 10px;
            }
            .form-control:focus {
                border-color: #00A000;
                box-shadow: 0 0 0 0.25rem rgba(0, 160, 0, 0.25);
            }
            .text-success {
                color: #00A000 !important;
            }
        </style>

        <!-- Bootstrap JS - Framework JavaScript untuk interaksi -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="min-vh-100 bg-light">
            <!-- Navigation - Menu navigasi aplikasi -->
            @include('layouts.navigation')

            <!-- Page Heading - Header halaman (opsional) -->
            @isset($header)
                <header class="bg-white shadow-sm">
                    <div class="container py-3">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content - Konten utama halaman -->
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>
