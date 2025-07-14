{{--
    Halaman login user
    Berisi:
    - Logo & judul aplikasi
    - Form login (email, password, remember me)
    - Link lupa password
--}}

<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        {{-- Logo & judul aplikasi --}}
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/Lambang_Kota_Palu_(2015-sekarang).png') }}" alt="Logo" class="img-fluid mb-4" style="max-width: 150px;">
                            <h1 class="text-center fw-bold mb-2" style="color: #1976D2;">Selamat Datang Di</h1>
                            <h1 class="text-center fw-bold mb-2" style="color: #1976D2;">SI ARSIPS</h1>
                            <div class="text-center fw-bold mb-4" style="color: #1976D2; font-size:1.2rem;">(Sistem Informasih Arsip Statis)</div>
                        </div>

                        {{-- Form login --}}
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label" style="color: #1976D2;">Email</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label" style="color: #1976D2;">Password</label>
                                <input id="password" class="form-control" type="password" name="password" required>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                    <label class="form-check-label" for="remember_me" style="color: #1976D2;">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" style="color: #1976D2;" href="{{ route('password.request') }}">
                                        Forgot your password?
                                    </a>
                                @endif

                                <button type="submit" class="btn px-4" style="background-color: #1976D2; color: #fff;">
                                    Log in
                                </button>
                            </div>

                            <div class="text-center">
                                <!-- Tulisan 'Don't have an account?' dihilangkan -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
