<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB SMA Negeri 1 - Tahun 2025/2026</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #2563eb;
            --secondary: #1e40af;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* HERO */
        .hero-section {
            background:
                linear-gradient(135deg, rgba(37,99,235,.85), rgba(30,64,175,.85)),
                url('{{ asset('images/hero-school.jpg') }}');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0 80px;
        }

        .countdown-box {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border-radius: 15px;
            padding: 30px;
        }

        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,.08);
        }

        .jurusan-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,.08);
            overflow: hidden;
            height: 100%;
        }

        footer {
            background: #1f2937;
            color: white;
            padding: 40px 0 20px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">
            <i class="bi bi-mortarboard-fill"></i> PPDB SMA Negeri 1
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#jurusan">Jurusan</a></li>
                <li class="nav-item"><a class="nav-link" href="#alur">Alur</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>

                @guest
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
                    </li>
                @else
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary btn-sm"
                           href="{{ auth()->user()->role === 'admin'
                                ? route('admin.dashboard')
                                : route('siswa.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section id="beranda" class="hero-section" style="margin-top:70px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <h1 class="fw-bold display-5">PPDB SMA Negeri 1</h1>
                <h4 class="mb-3">Tahun Ajaran 2025 / 2026</h4>
                <p class="lead">Sekolah unggulan untuk mencetak generasi berprestasi dan berkarakter.</p>

                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">
                    <i class="bi bi-pencil-square"></i> Daftar Sekarang
                </a>

                <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#cekStatusModal">
                    <i class="bi bi-search"></i> Cek Status
                </button>
            </div>

            <div class="col-lg-6">
                <div class="countdown-box text-center">
                    <h5>Penutupan Pendaftaran</h5>
                    <div class="row mt-4">
                        <div class="col-3">
                            <h2 id="days">{{ $sisaHari }}</h2>
                            <small>Hari</small>
                        </div>
                        <div class="col-3">
                            <h2 id="hours">00</h2>
                            <small>Jam</small>
                        </div>
                        <div class="col-3">
                            <h2 id="minutes">00</h2>
                            <small>Menit</small>
                        </div>
                        <div class="col-3">
                            <h2 id="seconds">00</h2>
                            <small>Detik</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATISTIK -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                    <h3>{{ $totalPendaftar }}</h3>
                    <small>Pendaftar</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="bi bi-award-fill fs-1 text-success"></i>
                    <h3>{{ $totalKuota }}</h3>
                    <small>Kuota</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="bi bi-calendar-event fs-1 text-warning"></i>
                    <h3>{{ $sisaHari }}</h3>
                    <small>Hari Tersisa</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <i class="bi bi-book-fill fs-1 text-danger"></i>
                    <h3>{{ $jurusanTersedia }}</h3>
                    <small>Jurusan</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JURUSAN -->
<section id="jurusan" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Jurusan Tersedia</h2>

        <div class="row g-4 justify-content-center">

            <!-- IPA -->
            <div class="col-md-4">
                <div class="jurusan-card text-center p-4">
                    <i class="bi bi-flask fs-1 text-primary mb-3"></i>
                    <h4>Ilmu Pengetahuan Alam (IPA)</h4>
                    <p class="text-muted">
                        Fokus pada sains, eksperimen, dan logika ilmiah untuk
                        mempersiapkan siswa ke jenjang pendidikan tinggi.
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-primary w-100">
                        Daftar IPA
                    </a>
                </div>
            </div>

            <!-- IPS -->
            <div class="col-md-4">
                <div class="jurusan-card text-center p-4">
                    <i class="bi bi-globe-asia-australia fs-1 text-success mb-3"></i>
                    <h4>Ilmu Pengetahuan Sosial (IPS)</h4>
                    <p class="text-muted">
                        Mempelajari ekonomi, geografi, dan sosiologi untuk
                        membentuk pemahaman sosial yang luas.
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-success w-100">
                        Daftar IPS
                    </a>
                </div>
            </div>

            <!-- BAHASA -->
            <div class="col-md-4">
                <div class="jurusan-card text-center p-4">
                    <i class="bi bi-translate fs-1 text-warning mb-3"></i>
                    <h4>Bahasa</h4>
                    <p class="text-muted">
                        Mengembangkan kemampuan bahasa, literasi, dan komunikasi
                        untuk kebutuhan global.
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-warning w-100">
                        Daftar Bahasa
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ALUR -->
<section id="alur" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Alur Pendaftaran</h2>
        <div class="row g-4">
            <div class="col"><i class="bi bi-pencil-square fs-1"></i><p>Registrasi</p></div>
            <div class="col"><i class="bi bi-file-text fs-1"></i><p>Isi Data</p></div>
            <div class="col"><i class="bi bi-upload fs-1"></i><p>Upload Berkas</p></div>
            <div class="col"><i class="bi bi-check-circle fs-1"></i><p>Verifikasi</p></div>
            <div class="col"><i class="bi bi-megaphone fs-1"></i><p>Pengumuman</p></div>
        </div>
    </div>
</section>

<!-- KONTAK -->
<section id="kontak" class="py-5 text-center">
    <h2>Hubungi Kami</h2>
    <p>Email: ppdb@sman1.sch.id | Telp: (021) 12345678</p>
</section>

<!-- FOOTER -->
<footer class="text-center">
    <p>&copy; {{ date('Y') }} SMA Negeri 1 - PPDB</p>
</footer>

<!-- MODAL CEK STATUS -->
<div class="modal fade" id="cekStatusModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ url('/cek-status') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5>Cek Status Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="nomor_pendaftaran" class="form-control"
                       placeholder="PPDB-2025-001" required>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Cek</button>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function updateCountdown() {
    const target = new Date('2025-07-31T23:59:59').getTime();
    const now = new Date().getTime();
    const d = target - now;

    if (d < 0) return;

    document.getElementById('days').innerText = Math.floor(d / (1000*60*60*24));
    document.getElementById('hours').innerText = Math.floor((d / (1000*60*60)) % 24);
    document.getElementById('minutes').innerText = Math.floor((d / (1000*60)) % 60);
    document.getElementById('seconds').innerText = Math.floor((d / 1000) % 60);
}
setInterval(updateCountdown, 1000);
</script>

</body>
</html>
