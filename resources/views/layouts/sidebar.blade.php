<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    {{-- BRAND --}}
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">
                PPDB SMA
            </span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- DASHBOARD --}}
        <li class="menu-item {{ Request::is('*/dashboard') ? 'active' : '' }}">
            <a href="{{ Auth::user()->role == 'admin' ? '/admin/dashboard' : '/siswa/dashboard' }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        {{-- KEMBALI KE BERANDA --}}
        <li class="menu-item {{ Request::is('/') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-arrow-back"></i>
                <div>Kembali ke Beranda</div>
            </a>
        </li>

        {{-- ================= ADMIN ================= --}}
        @if(Auth::user() && Auth::user()->role == 'admin')

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Panitia</span>
            </li>

            {{-- VERIFIKASI --}}
            <li class="menu-item {{ Request::is('admin/verifikasi*') ? 'active' : '' }}">
                <a href="/admin/verifikasi" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-check"></i>
                    <div>Verifikasi Data</div>
                </a>
            </li>

            {{-- DATA JURUSAN --}}
            <li class="menu-item {{ Route::is('admin.jurusan*') ? 'active' : '' }}">
                <a href="{{ route('admin.jurusan') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-buildings"></i>
                    <div>Data Jurusan</div>
                </a>
            </li>

        {{-- ================= SISWA ================= --}}
        @else

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Siswa</span>
            </li>

            {{-- FORM PENDAFTARAN --}}
            <li class="menu-item {{ Request::is('siswa/pendaftaran*') ? 'active' : '' }}">
                <a href="/siswa/pendaftaran" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                    <div>Form Pendaftaran</div>
                </a>
            </li>

            {{-- STATUS --}}
            <li class="menu-item {{ Request::is('siswa/status*') ? 'active' : '' }}">
                <a href="/siswa/status" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-info-circle"></i>
                    <div>Status Seleksi</div>
                </a>
            </li>

        @endif

    </ul>
</aside>
