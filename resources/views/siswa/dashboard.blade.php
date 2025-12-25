@extends('layouts.master')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Datang, {{ Auth::user()->name }}! 🎉</h5>
                        <p class="mb-4">
                            Status pendaftaran Anda saat ini adalah: 
                            @if(!$pendaftaran)
                                <span class="badge bg-label-danger">Belum Mendaftar</span>
                            @else
                                <span class="badge bg-label-info">{{ $pendaftaran->status_pendaftaran }}</span>
                            @endif
                        </p>

                        @if(!$pendaftaran)
                            <a href="{{ route('siswa.pendaftaran') }}" class="btn btn-sm btn-primary">Mulai Daftar</a>
                        @else
                            <a href="{{ route('siswa.pendaftaran') }}" class="btn btn-sm btn-outline-primary">Edit Data</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($pendaftaran)
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>NISN</span>
                        <h4 class="mb-0 mt-2">{{ $pendaftaran->nisn }}</h4>
                        <small class="text-muted">Nomor Induk Siswa Nasional</small>
                    </div>
                    <span class="badge bg-label-primary rounded p-2"><i class="bx bx-user"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Jurusan Pilihan</span>
                        <h4 class="mb-0 mt-2">{{ $pendaftaran->major->nama_jurusan }}</h4>
                        <small class="text-muted">Program Keahlian</small>
                    </div>
                    <span class="badge bg-label-success rounded p-2"><i class="bx bx-buildings"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Informasi Pendaftaran</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th style="width: 30%">Foto Profil</th>
                        <td>: 
                            @if($pendaftaran && $pendaftaran->foto)
                                <img src="{{ asset($pendaftaran->foto) }}" alt="Foto Siswa" class="rounded shadow-sm" style="width: 100px; height: 130px; object-fit: cover;">
                            @else
                                <span class="badge bg-label-secondary">Belum ada foto</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>: {{ $pendaftaran->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NISN</th>
                        <td>: {{ $pendaftaran->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>: {{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : ($pendaftaran->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>: {{ $pendaftaran->tempat_lahir ?? '-' }}, {{ $pendaftaran->tanggal_lahir ? date('d F Y', strtotime($pendaftaran->tanggal_lahir)) : '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. WhatsApp</th>
                        <td>: {{ $pendaftaran->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $pendaftaran->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Rata-rata</th>
                        <td>: 
                            @if($pendaftaran && $pendaftaran->grade)
                                @php
                                    $avg = ($pendaftaran->grade->sem1 + $pendaftaran->grade->sem2 + $pendaftaran->grade->sem3 + $pendaftaran->grade->sem4 + $pendaftaran->grade->sem5) / 5;
                                @endphp
                                <span class="badge bg-label-primary fw-bold">{{ number_format($avg, 2) }}</span>
                            @else
                                <span class="text-muted">Belum diisi</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
    @endif
</div>
@endsection