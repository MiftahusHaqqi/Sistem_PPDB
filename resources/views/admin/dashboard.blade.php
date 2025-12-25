@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Total Pendaftar</span>
                        <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2">{{ $count['total'] }}</h4>
                        </div>
                        <small>Siswa</small>
                    </div>
                    <span class="badge bg-label-primary rounded p-2">
                        <i class="bx bx-user bx-sm"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Belum Verifikasi</span>
                        <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2">{{ $count['pending'] }}</h4>
                        </div>
                        <small class="text-danger">Perlu dicek</small>
                    </div>
                    <span class="badge bg-label-danger rounded p-2">
                        <i class="bx bx-error bx-sm"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Terverifikasi</span>
                        <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2">{{ $count['verif'] }}</h4>
                        </div>
                        <small class="text-success">Data aman</small>
                    </div>
                    <span class="badge bg-label-success rounded p-2">
                        <i class="bx bx-check-double bx-sm"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Lulus Seleksi</span>
                        <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2">{{ $count['lulus'] }}</h4>
                        </div>
                        <small>Final</small>
                    </div>
                    <span class="badge bg-label-info rounded p-2">
                        <i class="bx bx-trophy bx-sm"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Kuota per Jurusan</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th>Kuota</th>
                            <th>Pendaftar</th>
                            <th>Status Kapasitas</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($majors as $m)
                        <tr>
                            <td><strong>{{ $m->nama_jurusan }}</strong></td>
                            <td>{{ $m->kuota }}</td>
                            <td>{{ $m->registrations_count }}</td>
                            <td>
                                @php
                                    $persen = ($m->registrations_count / $m->kuota) * 100;
                                    $warna = $persen > 80 ? 'danger' : ($persen > 50 ? 'warning' : 'success');
                                @endphp
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $warna }}" role="progressbar" style="width: <?php echo $persen; ?>%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection