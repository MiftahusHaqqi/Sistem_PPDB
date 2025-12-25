@extends('layouts.master')

@section('title', 'Status Pendaftaran')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Siswa /</span> Status Seleksi</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Progres Pendaftaran</h5>
                <small class="text-muted float-end">Update Terakhir: {{ $pendaftaran ? $pendaftaran->updated_at->format('d M Y') : '-' }}</small>
            </div>
            <div class="card-body">
                @if(!$pendaftaran)
                    <div class="alert alert-warning d-flex" role="alert">
                        <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2">
                            <i class="bx bx-error-circle fs-4"></i>
                        </span>
                        <div class="d-flex flex-column ps-1">
                            <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Data Belum Ditemukan!</h6>
                            <span>Anda belum mengisi formulir pendaftaran. Silakan <a href="{{ route('siswa.pendaftaran') }}" class="fw-bold">Klik di Sini</a> untuk mendaftar.</span>
                        </div>
                    </div>
                @else
                    <div class="row mb-4">
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <div class="avatar me-2">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-hash"></i></span>
                                        </div>
                                        <h4 class="ms-1 mb-0">{{ $pendaftaran->nomor_pendaftaran }}</h4>
                                    </div>
                                    <p class="mb-1">No. Pendaftaran</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card card-border-shadow-info h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <div class="avatar me-2">
                                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-buildings"></i></span>
                                        </div>
                                        <h4 class="ms-1 mb-0">{{ $pendaftaran->major->nama_jurusan }}</h4>
                                    </div>
                                    <p class="mb-1">Pilihan Jurusan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="timeline mt-3">
                        <li class="timeline-item timeline-item-transparent {{ $pendaftaran->status_pendaftaran != 'Belum Diverifikasi' ? 'border-primary' : 'border-left-dashed' }}">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-primary"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Pendaftaran Terkirim</h6>
                                    <small class="text-muted">Selesai</small>
                                </div>
                                <p class="mb-2">Data Anda telah masuk ke sistem kami.</p>
                            </div>
                        </li>
                        
                        <li class="timeline-item timeline-item-transparent {{ $pendaftaran->status_pendaftaran == 'Terverifikasi' || $pendaftaran->status_pendaftaran == 'Lulus' ? 'border-primary' : 'border-left-dashed' }}">
                            <span class="timeline-point-wrapper">
                                <span class="timeline-point {{ $pendaftaran->status_pendaftaran == 'Belum Diverifikasi' ? 'timeline-point-warning' : 'timeline-point-primary' }}"></span>
                            </span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Verifikasi Berkas</h6>
                                    <small class="text-muted">{{ $pendaftaran->status_pendaftaran == 'Belum Diverifikasi' ? 'Proses' : 'Selesai' }}</small>
                                </div>
                                <p class="mb-2">Panitia sedang memeriksa kelengkapan dokumen pendaftaran Anda.</p>
                                @if($pendaftaran->status_pendaftaran == 'Belum Diverifikasi')
                                    <span class="badge bg-label-warning">Menunggu Verifikasi</span>
                                @else
                                    <span class="badge bg-label-success">Terverifikasi</span>
                                @endif
                            </div>
                        </li>

<li class="timeline-item timeline-item-transparent border-transparent">
    <span class="timeline-point-wrapper">
        {{-- Point akan berwarna hijau jika Lulus & Final, Merah jika Tidak Lulus & Final --}}
        <span class="timeline-point 
            {{ $pendaftaran->is_final && $pendaftaran->status_pendaftaran == 'Terverifikasi' ? 'timeline-point-success' : 
               ($pendaftaran->is_final && $pendaftaran->status_pendaftaran == 'Tidak Lulus' ? 'timeline-point-danger' : 'timeline-point-secondary') }}">
        </span>
    </span>
    <div class="timeline-event">
        <div class="timeline-header mb-1">
            <h6 class="mb-0">Pengumuman Akhir</h6>
            <small class="text-muted">Final</small>
        </div>
        <p class="mb-2">Hasil seleksi penerimaan siswa baru.</p>

        {{-- Logika Pengumuman Final --}}
        @if($pendaftaran->is_final)
            @if($pendaftaran->status_pendaftaran == 'Terverifikasi')
                <div class="alert alert-success d-flex mb-0" role="alert">
                    <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
                        <i class="bx bx-party fs-4"></i>
                    </span>
                    <div class="d-flex flex-column ps-1">
                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Selamat!</h6>
                        <span>Anda dinyatakan **LULUS** seleksi dan diterima di SMA. Silakan lakukan daftar ulang.</span>
                        <a href="{{ route('siswa.cetak') }}" class="btn btn-primary mt-3">
                            <i class="bx bx-download me-1"></i> Cetak Bukti Kelulusan (PDF)
                        </a>
                    </div>
                </div>
            @elseif($pendaftaran->status_pendaftaran == 'Tidak Lulus')
                <div class="alert alert-danger d-flex mb-0" role="alert">
                    <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">
                        <i class="bx bx-sad fs-4"></i>
                    </span>
                    <div class="d-flex flex-column ps-1">
                        <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Mohon Maaf</h6>
                        <span>Anda dinyatakan **TIDAK LULUS** seleksi tahun ini. Tetap semangat!</span>
                    </div>
                </div>
            @endif
        @else
            {{-- Jika Belum Final --}}
            <span class="badge bg-label-secondary">Belum Diumumkan</span>
            <p class="text-muted small mt-2 italic">Hasil seleksi akan diumumkan secara serentak setelah proses verifikasi selesai.</p>
        @endif
    </div>
</li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection