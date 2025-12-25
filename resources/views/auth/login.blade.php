@extends('layouts.blank') {{-- Layout khusus auth dari Sneat --}}

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2 text-center">Selamat Datang di PPDB! 👋</h4>
                    <p class="mb-4 text-center">Silakan masuk ke akun Anda</p>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required autofocus>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="········" required>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                        </div>
                    </form>

                    <p class="text-center">
                        <span>Belum punya akun?</span>
                        <a href="{{ route('register') }}">
                            <span>Daftar Sekarang</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection