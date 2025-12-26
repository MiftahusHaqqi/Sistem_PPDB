@extends('layouts.master')

@section('title', 'Detail Pendaftar')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Detail Pendaftar
</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">Data Siswa</div>
            <div class="card-body">
                <p><b>Nama:</b> {{ $pendaftar->nama_lengkap }}</p>
                <p><b>NISN:</b> {{ $pendaftar->nisn }}</p>
                <p><b>Jurusan:</b> {{ $pendaftar->major->nama_jurusan }}</p>
                <p><b>Status:</b> {{ $pendaftar->status_pendaftaran }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Nilai</div>
            <div class="card-body">
                <p><b>Rata-rata:</b> {{ $pendaftar->grade->rata_rata ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="card">
    <div class="card-header">Dokumen Diupload</div>
    <div class="card-body">

        @php
            $doc = $pendaftar->documents;
        @endphp

        @if($doc)

            @if($doc->file_kk && $doc->file_kk != '-')
                <div class="mb-2">
                    <strong>KK</strong><br>
                    <a href="{{ asset($doc->file_kk) }}" target="_blank">
                        Lihat Dokumen
                    </a>
                </div>
            @endif

            @if($doc->file_ijazah_skl && $doc->file_ijazah_skl != '-')
                <div class="mb-2">
                    <strong>Ijazah / SKL</strong><br>
                    <a href="{{ asset($doc->file_ijazah_skl) }}" target="_blank">
                        Lihat Dokumen
                    </a>
                </div>
            @endif

            @if($doc->file_akta && $doc->file_akta != '-')
                <div class="mb-2">
                    <strong>Akta</strong><br>
                    <a href="{{ asset($doc->file_akta) }}" target="_blank">
                        Lihat Dokumen
                    </a>
                </div>
            @endif

            @if($doc->file_rapor_gabungan && $doc->file_rapor_gabungan != '-')
                <div class="mb-2">
                    <strong>Rapor Gabungan</strong><br>
                    <a href="{{ asset($doc->file_rapor_gabungan) }}" target="_blank">
                        Lihat Dokumen
                    </a>
                </div>
            @endif

        @else
            <span class="text-muted">Belum ada dokumen yang diupload.</span>
        @endif

    </div>
</div>


<div class="mt-4 d-flex gap-2">
    <form action="{{ route('admin.verifikasi.update', $pendaftar->id) }}" method="POST">
        @csrf
        <input type="hidden" name="status" value="Terverifikasi">
        <button class="btn btn-success">Verifikasi</button>
    </form>

    <form action="{{ route('admin.verifikasi.update', $pendaftar->id) }}" method="POST">
        @csrf
        <input type="hidden" name="status" value="Tidak Lulus">
        <button class="btn btn-danger">Tolak</button>
    </form>

    <a href="{{ route('admin.verifikasi') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
