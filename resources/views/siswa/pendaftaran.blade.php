@extends('layouts.master')

@section('title', 'Form Pendaftaran Online')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pendaftaran /</span> Input Data Calon Siswa</h4>

<form action="{{ route('siswa.pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Identitas</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        {{-- Gunakan old() agar input tidak hilang jika validasi gagal, dan $pendaftaran sebagai default --}}
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Sesuai Ijazah" 
                               value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap ?? '') }}" required />
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" placeholder="10 Digit" maxlength="10" 
                                   value="{{ old('nisn', $pendaftaran->nisn ?? '') }}" required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" 
                                   value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir ?? '') }}" required />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" 
                                   value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir ?? '') }}" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="0812..." 
                               value="{{ old('no_hp', $pendaftaran->no_hp ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $pendaftaran->alamat ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Dokumen Pendukung (Format: PDF/JPG, Max: 2MB)</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kartu Keluarga (KK)</label>
                <input type="file" name="file_kk" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                @if($pendaftaran && $pendaftaran->document && $pendaftaran->document->file_kk != '-')
                    <small class="text-success">File sudah ada: <a href="{{ asset($pendaftaran->document->file_kk) }}" target="_blank">Lihat File</a></small>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Ijazah / SKL</label>
                <input type="file" name="file_ijazah_skl" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                @if($pendaftaran && $pendaftaran->document && $pendaftaran->document->file_ijazah_skl != '-')
                    <small class="text-success">File sudah ada: <a href="{{ asset($pendaftaran->document->file_ijazah_skl) }}" target="_blank">Lihat File</a></small>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Akta Kelahiran</label>
                <input type="file" name="file_akta" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                @if($pendaftaran && $pendaftaran->document && $pendaftaran->document->file_akta != '-')
                    <small class="text-success">File sudah ada: <a href="{{ asset($pendaftaran->document->file_akta) }}" target="_blank">Lihat File</a></small>
                @endif
            </div>
        </div>
    </div>
</div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sekolah & Jurusan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Sekolah Asal</label>
                        <input type="text" name="asal_sekolah" class="form-control" placeholder="SMP/MTs Asal" 
                               value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilihan Jurusan</label>
                        <select name="major_id" class="form-select" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusan as $j)
                                <option value="{{ $j->id }}" {{ old('major_id', $pendaftaran->major_id ?? '') == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Foto (3x4)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" {{ isset($pendaftaran) ? '' : 'required' }} />
                        @if(isset($pendaftaran->foto))
                            <div class="mt-2">
                                <small class="text-muted">Foto saat ini:</small><br>
                                <img src="{{ asset($pendaftaran->foto) }}" width="80" class="rounded shadow-sm">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Nilai Rapor (Semester 1 - 5)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            // Ambil data nilai dari relasi jika ada
                            $grades = $pendaftaran->grade ?? null;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                        @php $field = 'sem'.$i; @endphp
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Smt {{ $i }}</label>
                            <input type="number" step="0.01" name="sem{{ $i }}" class="form-control" placeholder="00.00" 
                                   value="{{ old($field, $grades->$field ?? '') }}" required />
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center mb-5">
            <button type="submit" class="btn btn-primary btn-lg">
                {{ isset($pendaftaran) ? 'Update Perubahan' : 'Kirim Pendaftaran' }}
            </button>
        </div>
    </div>
</form>
@endsection