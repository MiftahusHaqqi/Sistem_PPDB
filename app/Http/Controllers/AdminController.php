<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Major;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Statistik Ringkas
        $count = [
            'total' => Registration::count(),
            'verif' => Registration::where('status_pendaftaran', 'Terverifikasi')->count(),
            'pending' => Registration::where('status_pendaftaran', 'Belum Diverifikasi')->count(),
            'lulus' => Registration::where('status_pendaftaran', 'Terverifikasi')
                ->where('is_final', 1)
                ->count(),

        ];

        // Data untuk tabel atau grafik (opsional)
        $majors = Major::withCount('registrations')->get();

        return view('admin.dashboard', compact('count', 'majors'));
    }

    public function verifikasi(Request $request)
    {
        // 1. Mulai dengan query dasar + eager loading
        $query = Registration::with(['grade', 'major']);

        // 2. Logika Search (Nama atau NISN)
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        // 3. Logika Filter Jurusan
        if ($request->has('major_id') && $request->major_id != '') {
            $query->where('major_id', $request->major_id);
        }

        // 4. Ambil data dengan pagination agar tidak berat
        $pendaftar = $query->latest()->paginate(10);

        // 5. Ambil data jurusan untuk dropdown filter
        $majors = Major::all();

        return view('admin.verifikasi', compact('pendaftar', 'majors'));
    }

    public function show($id)
    {
        $pendaftar = Registration::with(['documents', 'grade', 'major', 'user'])
            ->findOrFail($id);

        return view('admin.pendaftar-detail', compact('pendaftar'));
    }

    public function verifikasiPendaftar($id)
    {
        $p = Registration::findOrFail($id);

        if ($p->status_pendaftaran === 'ditolak') {
            return back()->with('error', 'Pendaftaran sudah ditolak');
        }

        $p->status_pendaftaran = 'Terverifikasi';
        $p->save();

        return back()->with('success', 'Pendaftaran berhasil diverifikasi');
    }

    public function batalVerifikasiPendaftar($id)
    {
        $p = Registration::findOrFail($id);

        if ($p->status_pendaftaran !== 'Terverifikasi') {
            return back()->with('error', 'Status tidak valid');
        }

        $p->status_pendaftaran = 'Belum Diverifikasi';
        $p->save();

        return back()->with('success', 'Verifikasi berhasil dibatalkan');
    }

    public function tolakPendaftar($id)
    {
        $p = Registration::findOrFail($id);

        $p->status_pendaftaran = 'Tidak Lulus';
        $p->save();

        return back()->with(
            'success',
            'Pendaftaran ditolak. Siswa harus mengajukan ulang.'
        );
    }




    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Registration::findOrFail($id);

        $pendaftaran->status_pendaftaran = $request->status;
        $pendaftaran->save();

        return back()->with('success', 'Status pendaftaran ' . $pendaftaran->nama_lengkap . ' berhasil diupdate!');
    }

    public function jurusan()
    {
        $jurusan = Major::withCount('registrations')->get();
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function jurusanStore(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|unique:majors',
            'kuota' => 'required|numeric'
        ]);

        Major::create($request->all());
        return back()->with('success', 'Jurusan baru berhasil ditambah!');
    }

    public function jurusanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required|unique:majors,nama_jurusan,' . $id,
            'kuota' => 'required|numeric'
        ]);

        $jurusan = Major::findOrFail($id);
        $jurusan->update($request->all());

        return back()->with('success', 'Data jurusan berhasil diperbarui!');
    }

    public function jurusanDelete($id)
    {
        $jurusan = Major::findOrFail($id);

        // Cek apakah ada siswa yang terdaftar di jurusan ini
        if ($jurusan->registrations()->count() > 0) {
            return back()->with('error', 'Jurusan tidak bisa dihapus karena masih ada siswa yang mendaftar!');
        }

        $jurusan->delete();
        return back()->with('success', 'Jurusan berhasil dihapus!');
    }

    public function umumkanFinal()
    {
        // Update SEMUA pendaftaran yang sudah tidak berstatus 'Belum Diverifikasi'
        // Kita gunakan trim() untuk jaga-jaga jika ada spasi tak terlihat di database
        $affected = Registration::where('status_pendaftaran', '!=', 'Belum Diverifikasi')
            ->update(['is_final' => 1]);

        return redirect()->back()->with('success', 'Berhasil mengumumkan ' . $affected . ' siswa.');
    }
}
