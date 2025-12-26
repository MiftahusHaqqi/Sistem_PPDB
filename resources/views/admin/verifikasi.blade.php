@extends('layouts.master')

@section('title', 'Verifikasi Pendaftar')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Verifikasi Pendaftar</h4>

<form action="{{ route('admin.umumkan.final') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengumumkan hasil pendaftaran? Aksi ini tidak dapat dibatalkan.')">
    @csrf
    <div class="alert alert-warning">
        <strong>Info Pengumuman:</strong> Tekan tombol di bawah untuk mempublikasikan status hasil seleksi kepada seluruh siswa secara serentak.
        <button type="submit" class="btn btn-danger btn-sm ms-3">Umumkan Hasil Final</button>
    </div>
</form>
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.verifikasi') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama atau NISN..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="major_id" class="form-select">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach($majors as $m)
                        <option value="{{ $m->id }}" {{ request('major_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>
<div class="col-md-4 d-flex align-items-end">
    <div class="d-flex gap-2"> {{-- gap-2 memberikan jarak antar elemen --}}
        <button type="submit" class="btn btn-primary">
            <i class="bx bx-filter-alt me-1"></i> Filter
        </button>
        <a href="{{ route('admin.verifikasi') }}" class="btn btn-outline-secondary">
            <i class="bx bx-refresh me-1"></i> Reset
        </a>
    </div>
</div>
        </form>
    </div>
</div>
<div class="card">
    <h5 class="card-header">Daftar Calon Siswa</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>NISN</th>
                    <th>Jurusan</th>
                    <th>Rata-rata Nilai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($pendaftar as $p)
                <tr>
                    <td>
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="avatar me-2">
                                <img src="{{ asset($p->foto ?? 'assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" style="object-fit: cover">
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('admin.pendaftar.show', $p->id) }}"
                                    class="fw-semibold text-decoration-none">
                                        {{ $p->nama_lengkap }}
                                </a>
                                <small class="text-muted">{{ $p->nomor_pendaftaran }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $p->nisn }}</td>
                    <td><span class="badge bg-label-primary">{{ $p->major->nama_jurusan }}</span></td>
                    <td><strong>{{ $p->grade->rata_rata ?? '0' }}</strong></td>
                    <td>
                        @if($p->status_pendaftaran == 'Belum Diverifikasi')
                            <span class="badge bg-label-warning">Pending</span>
                        @elseif($p->status_pendaftaran == 'Terverifikasi')
                            <span class="badge bg-label-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-label-info">{{ $p->status_pendaftaran }}</span>
                        @endif
                    </td>
<td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <form action="{{ route('admin.verifikasi.update', $p->id) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="Terverifikasi">
            <button type="submit" class="btn btn-sm btn-success" title="Verifikasi">
                <i class="bx bx-check"></i>
            </button>
        </form>

        <form action="{{ route('admin.verifikasi.update', $p->id) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="Tidak Lulus">
            <button type="submit" class="btn btn-sm btn-danger" title="Tolak">
                <i class="bx bx-x"></i>
            </button>
        </form>
    </div>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection