<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login PPDB</title>
    {{-- Masukkan semua CSS Sneat Anda di sini --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
</head>
<body>
    {{-- LANGSUNG YIELD CONTENT TANPA INCLUDE SIDEBAR --}}
    @yield('content')

    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
</body>
</html>