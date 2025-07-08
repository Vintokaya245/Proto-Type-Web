<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/ikon1-removebg-preview.png') }}" alt="Logo" class="img-fluid mb-4" style="max-width: 150px;">
                            <h2 class="text-success fw-bold">Create New Account</h2>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label text-success">Name</label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label text-success">Email</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label text-success">Password</label>
                                <input id="password" class="form-control" type="password" name="password" required>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label text-success">Confirm Password</label>
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a class="text-success text-decoration-none" href="{{ route('login') }}">
                                    Already registered?
                                </a>

                                <button type="submit" class="btn btn-success px-4">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
