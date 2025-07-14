<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI ARSIPS (Sistem Informasih Arsip Statis)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
    <!--
        Halaman utama (landing page) aplikasi SI ARSIPS
        Berisi:
        - Navbar navigasi
        - Hero section (gambar utama & judul)
        - Section Fitur Utama
        - Statistik Arsip
        - Testimoni
        - Footer
    -->

    <!-- Navbar Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1976D2;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SI ARSIPS (Sistem Informasih Arsip Statis)</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#fitur-utama">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#statistik-arsip">Arsip</a></li>
                </ul>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-light ms-3">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light ms-3">Login</a>
                        @if (Route::has('register'))
                            <!-- <a href="{{ route('register') }}" class="btn btn-light ms-2">Register</a> -->
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section: Gambar utama & judul aplikasi -->
    <header class="bg-dark text-white text-center py-5" style="background: url('{{ asset('img/IMG_20231009_132916-scaled.jpg') }}') center/cover no-repeat;">
        <div class="container py-5">
            <h1 class="display-4 fw-bold">SI ARSIPS (Sistem Informasih Arsip Statis)</h1>
            <p class="lead">Kelola arsip dan dokumen dengan sistem yang terorganisir dan efisien</p>
        </div>
        </header>

    <!-- Categories Section -->
    <section id="fitur-utama" class="container my-5 text-center" style="scroll-margin-top: 180px;">
        <!--
            scroll-margin-top: 180px;
            Penjelasan: Properti CSS ini digunakan agar saat user klik menu navigasi 'Fitur', halaman akan scroll ke section 'Fitur Utama' dengan posisi pas di bawah navbar. Nilai 180px disesuaikan agar card statistic tidak ikut kelihatan di atasnya.
        -->
        <h2 class="mb-4">Fitur Utama</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/Screenshot (3848).png') }}" class="card-img-top" alt="Kelola Arsip" style="width:100%; height:220px; object-fit:contain; background:#fff;">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Arsip</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/Screenshot (3847).png') }}" class="card-img-top" alt="Periode Arsip" style="width:100%; height:220px; object-fit:contain; background:#fff;">
                    <div class="card-body">
                        <h5 class="card-title">Periode Arsip</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/Screenshot (3887).png') }}" class="card-img-top" alt="Pencarian" style="width:100%; height:220px; object-fit:contain; background:#fff;">
                    <div class="card-body">
                        <h5 class="card-title">Pencarian</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow">
                    <img src="{{ asset('img/Screenshot (3882).png') }}" class="card-img-top" alt="Laporan" style="width:100%; height:220px; object-fit:contain; background:#fff;">
                    <div class="card-body">
                        <h5 class="card-title">Laporan</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Statistik Arsip: Menampilkan jumlah arsip -->
    <section id="statistik-arsip" class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card text-white mb-4" style="background-color: #e74c3c;">
                    <div class="card-body text-center">
                        <h2 class="fw-bold" style="font-size:2.5rem;">{{ isset($arsipCount) ? $arsipCount : 0 }} Arsip</h2>
                        <div>Data Arsip</div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Testimoni: Apa Kata Mereka -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-4" style="color: #1976D2;">Apa Kata Mereka</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow p-4">
                        <p class="fst-italic text-dark">"Sistem arsip ini sangat membantu dalam mengorganisir dokumen kami dengan lebih efisien."</p>
                        <p class="fw-bold" style="color: #1976D2;">- Admin Kantor</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow p-4">
                        <p class="fst-italic text-dark">"Interface yang user-friendly terutama pada fitur dowload excel dan pencarian yang sangat membantu."</p>
                        <p class="fw-bold" style="color: #1976D2;">- Staff Arsip</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer aplikasi -->
    <footer class="text-white text-center py-3" style="background-color: #1976D2;">
        <p>&copy; 2025 Sistem Arsip Statis. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
