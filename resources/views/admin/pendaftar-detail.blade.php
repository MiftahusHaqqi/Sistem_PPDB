@extends('layouts.master')

@section('title', 'Detail Pendaftar')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Detail Pendaftar
</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white font-weight-bold">Data Siswa</div>
            <div class="card-body">
                <p class="mb-2"><b>Nama:</b> {{ $pendaftar->nama_lengkap }}</p>
                <p class="mb-2"><b>NISN:</b> {{ $pendaftar->nisn }}</p>
                <p class="mb-2"><b>Jurusan:</b> {{ $pendaftar->major->nama_jurusan }}</p>
                <p class="mb-0"><b>Status:</b> 
                    <span class="badge {{ $pendaftar->status_pendaftaran == 'Terverifikasi' ? 'bg-success' : 'bg-warning' }}">
                        {{ $pendaftar->status_pendaftaran }}
                    </span>
                </p>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white font-weight-bold">Nilai</div>
            <div class="card-body">
                <p class="mb-0"><b>Rata-rata:</b> {{ $pendaftar->grade->rata_rata ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white font-weight-bold">Dokumen Diupload</div>
            <div class="card-body">
                @php $doc = $pendaftar->documents; @endphp

                @if($doc)
                    <div class="row">
                        @if($doc->file_kk && $doc->file_kk != '-')
                        <div class="col-6 mb-3">
                            <strong>KK</strong><br>
                            <a href="{{ asset($doc->file_kk) }}" class="btn btn-sm btn-outline-primary mt-1" target="_blank">Lihat Dokumen</a>
                        </div>
                        @endif

                        @if($doc->file_ijazah_skl && $doc->file_ijazah_skl != '-')
                        <div class="col-6 mb-3">
                            <strong>Ijazah / SKL</strong><br>
                            <a href="{{ asset($doc->file_ijazah_skl) }}" class="btn btn-sm btn-outline-primary mt-1" target="_blank">Lihat Dokumen</a>
                        </div>
                        @endif

                        @if($doc->file_akta && $doc->file_akta != '-')
                        <div class="col-6 mb-3">
                            <strong>Akta</strong><br>
                            <a href="{{ asset($doc->file_akta) }}" class="btn btn-sm btn-outline-primary mt-1" target="_blank">Lihat Dokumen</a>
                        </div>
                        @endif

                        @if($doc->file_rapor_gabungan && $doc->file_rapor_gabungan != '-')
                        <div class="col-6 mb-3">
                            <strong>Rapor Gabungan</strong><br>
                            <a href="{{ asset($doc->file_rapor_gabungan) }}" class="btn btn-sm btn-outline-primary mt-1" target="_blank">Lihat Dokumen</a>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-3">
                        <span class="text-muted">Belum ada dokumen yang diupload.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    @if($pendaftar->status_pendaftaran === 'Belum Diverifikasi')
        <form action="{{ route('admin.pendaftar.verifikasi', $pendaftar->id) }}" method="POST">
            @csrf @method('PATCH')
            <button class="btn btn-success"><i class="bx bx-check"></i> Verifikasi</button>
        </form>

        <form action="{{ route('admin.pendaftar.tolak', $pendaftar->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftar ini?')">
            @csrf @method('PATCH')
            <button class="btn btn-danger"><i class="bx bx-x"></i> Tolak</button>
        </form>

    @elseif($pendaftar->status_pendaftaran === 'Terverifikasi')
        <form action="{{ route('admin.pendaftar.batal', $pendaftar->id) }}" method="POST" onsubmit="return confirm('Batalkan verifikasi?')">
            @csrf @method('PATCH')
            <button class="btn btn-warning"><i class="bx bx-undo"></i> Batalkan Verifikasi</button>
        </form>

        <form action="{{ route('admin.pendaftar.tolak', $pendaftar->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftar ini?')">
            @csrf @method('PATCH')
            <button class="btn btn-danger"><i class="bx bx-x"></i> Tolak</button>
        </form>

    @elseif($pendaftar->status_pendaftaran === 'Tidak Lulus')
        <div class="alert alert-danger w-100">
            <strong>DITOLAK:</strong> Siswa ini dinyatakan tidak lulus verifikasi.
        </div>
    @endif
</div>
@endsection