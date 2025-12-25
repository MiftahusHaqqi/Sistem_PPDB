@extends('layouts.blank')

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <div class="app-brand justify-content-center mb-4">
                        <span class="app-brand-text demo text-body fw-bolder text-uppercase">PPDB SMA</span>
                    </div>
                    
                    <h4 class="mb-2">Petualangan dimulai di sini 🚀</h4>
                    <p class="mb-4">Buat akun siswa untuk mulai mendaftar!</p>

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="············" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="············" required>
                        </div>

                        <button class="btn btn-primary d-grid w-100" type="submit">Daftar Akun</button>
                    </form>

                    <p class="text-center mt-3">
                        <span>Sudah punya akun?</span>
                        <a href="{{ route('login') }}">
                            <span>Masuk sekarang</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection