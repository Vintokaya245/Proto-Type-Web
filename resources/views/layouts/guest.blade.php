<!--
    Layout utama untuk halaman guest (login, register, dsb)
    Berisi struktur HTML dasar, import CSS/JS, dan slot konten utama
-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom CSS -->
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
                border-color: #1976D2;
                box-shadow: 0 0 0 0.25rem rgba(25, 118, 210, 0.25);
            }
            .text-success {
                color: #00A000 !important;
            }
        </style>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
