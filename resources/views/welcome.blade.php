<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Arsip Statis - Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Sistem Arsip</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Arsip</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Periode</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
                <form class="d-flex ms-3">
                    <input class="form-control me-2" type="search" placeholder="Search arsip...">
            @if (Route::has('login'))
                    @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light me-2">Dashboard</a>
                    @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                        @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                        @endif
                    @endauth
                    @endif
                </form>
            </div>
        </div>
                </nav>

    <!-- Hero Section -->
    <header class="bg-dark text-white text-center py-5" style="background: url('{{ asset('img/jason-mavrommatis-XYrjl3j7smo-unsplash.jpg') }}') center/cover no-repeat;">
        <div class="container py-5">
            <h1 class="display-4 fw-bold">Sistem Arsip Statis</h1>
            <p class="lead">Kelola arsip dan dokumen dengan sistem yang terorganisir dan efisien</p>
            <a href="#" class="btn btn-success btn-lg">Mulai Sekarang</a>
        </div>
        </header>

    <!-- Categories Section -->
    <section class="container my-5 text-center">
        <h2 class="mb-4">Fitur Utama</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/charger.jpg') }}" class="card-img-top" alt="Kelola Arsip">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Arsip</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/bamboo.jpeg') }}" class="card-img-top" alt="Periode Arsip">
                    <div class="card-body">
                        <h5 class="card-title">Periode Arsip</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/download.jpeg') }}" class="card-img-top" alt="Pencarian">
                    <div class="card-body">
                        <h5 class="card-title">Pencarian</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/1111.jpeg') }}" class="card-img-top" alt="Laporan">
                    <div class="card-body">
                        <h5 class="card-title">Laporan</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Jumlah Arsip Publik (copy dari dashboard admin) -->
    <section class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card text-white mb-4" style="background-color: #e74c3c;">
                    <div class="card-body text-center">
                        <h2 class="fw-bold" style="font-size:2.5rem;">{{ isset($arsipCount) ? $arsipCount : 0 }} Arsip</h2>
                        <div>Data Arsip</div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center">
                        <a href="{{ url('/arsip') }}" class="btn btn-light btn-sm">
                            Lihat data <span>&#8594;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-4">Apa Kata Mereka</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow p-4">
                        <p class="fst-italic">"Sistem arsip ini sangat membantu dalam mengorganisir dokumen kami dengan lebih efisien."</p>
                        <p class="fw-bold text-success">- Admin Kantor</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow p-4">
                        <p class="fst-italic">"Interface yang user-friendly dan fitur pencarian yang sangat membantu."</p>
                        <p class="fw-bold text-success">- Staff Arsip</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-success text-white text-center py-3">
        <p>&copy; 2024 Sistem Arsip Statis. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
