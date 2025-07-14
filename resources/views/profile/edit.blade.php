{{--
    Halaman edit profile user
    Berisi:
    - Form edit data profile (nama, email)
    - Form update password
    - Form hapus akun
--}}

@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Notifikasi sukses - Menampilkan pesan setelah operasi berhasil --}}
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            @if(session('status') === 'profile-updated')
                <strong>Berhasil!</strong> Profile Anda telah diperbarui.
            @elseif(session('status') === 'password-updated')
                <strong>Berhasil!</strong> Password Anda telah diperbarui.
            @else
                {{ session('status') }}
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form edit data profile - Update nama dan email --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Profile</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
                        
                        {{-- Field nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @if($errors->get('name'))
                                <div class="alert alert-danger mt-2">
                                    @foreach($errors->get('name') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Field email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @if($errors->get('email'))
                                <div class="alert alert-danger mt-2">
                                    @foreach($errors->get('email') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Field role (readonly) --}}
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Form update password - Ganti password user --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Update Password</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        {{-- Field password saat ini --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            @if($errors->updatePassword->get('current_password'))
                                <div class="alert alert-danger mt-2">
                                    @foreach($errors->updatePassword->get('current_password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Field password baru --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @if($errors->updatePassword->get('password'))
                                <div class="alert alert-danger mt-2">
                                    @foreach($errors->updatePassword->get('password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Field konfirmasi password baru --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            @if($errors->updatePassword->get('password_confirmation'))
                                <div class="alert alert-danger mt-2">
                                    @foreach($errors->updatePassword->get('password_confirmation') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Form hapus akun - Hapus akun user secara permanen --}}
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Hapus Akun</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
                    
                    <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun?');">
                        @csrf
                        @method('delete')

                        {{-- Field password untuk konfirmasi hapus akun --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @if($errors->userDeletion->get('password'))
                                <div class="alert alert-danger mt-2">
                                    @foreach($errors->userDeletion->get('password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger">Hapus Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
