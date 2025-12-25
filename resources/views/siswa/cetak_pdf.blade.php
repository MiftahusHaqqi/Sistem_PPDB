<!DOCTYPE html>
<html>
<head>
    <title>Surat Keterangan Lulus</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .content { margin-top: 30px; }
        .status { font-weight: bold; color: green; font-size: 1.2em; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PANITIA PENDAFTARAN SISWA BARU</h2>
        <h1>SMA NEGERI 1 PPDB</h1>
        <p>Alamat Sekolah Anda, No. Telp, Website</p>
    </div>

    <div class="content">
        <h3 style="text-align: center;">SURAT KETERANGAN LULUS SELEKSI</h3>
        <p>Berdasarkan hasil verifikasi dokumen, pendaftar dengan data di bawah ini:</p>
        
        <table>
            <tr><td>No. Pendaftaran</td><td>: {{ $pendaftaran->nomor_pendaftaran }}</td></tr>
            <tr><td>Nama Lengkap</td><td>: {{ $pendaftaran->nama_lengkap }}</td></tr>
            <tr><td>NISN</td><td>: {{ $pendaftaran->nisn }}</td></tr>
            <tr><td>Jurusan Pilihan</td><td>: {{ $pendaftaran->major->nama_jurusan }}</td></tr>
        </table>

        <p>Dinyatakan: <span class="status">LULUS SELEKSI</span></p>
        <p>Silakan melakukan daftar ulang pada tanggal yang telah ditentukan dengan membawa surat ini.</p>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y') }}</p>
        <br><br><br>
        <p>( Panitia PPDB )</p>
    </div>
</body>
</html>