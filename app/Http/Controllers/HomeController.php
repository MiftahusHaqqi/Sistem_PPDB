<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Major;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data statistik
        $totalPendaftar = Registration::count();
        $totalKuota = Major::sum('kuota');
        $jurusanTersedia = Major::count();
        
        // Hitung sisa hari pendaftaran (contoh: tutup 31 Juli 2025)
        $tanggalTutup = new \DateTime('2025-07-31');
        $hariIni = new \DateTime();
        $sisaHari = $hariIni->diff($tanggalTutup)->days;
        
        // Ambil data jurusan dengan kuota
        $jurusan = Major::all();
        
        // Ambil data pendaftaran untuk statistik per jurusan
        $statistikJurusan = Major::withCount('registrations')->get();
        
        return view('welcome', compact(
            'totalPendaftar',
            'totalKuota',
            'jurusanTersedia',
            'sisaHari',
            'jurusan',
            'statistikJurusan'
        ));
    }
    
    public function tentang()
    {
        return view('tentang');
    }
    
    public function kontak()
    {
        return view('kontak');
    }
    
    public function cekStatus(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('cek-status');
        }
        
        $request->validate([
            'nomor_pendaftaran' => 'required|string'
        ]);
        
        $registration = Registration::with(['user', 'major', 'acceptedMajor'])
            ->where('nomor_pendaftaran', $request->nomor_pendaftaran)
            ->first();
        
        if (!$registration) {
            return back()->with('error', 'Nomor pendaftaran tidak ditemukan');
        }
        
        return view('hasil-status', compact('registration'));
    }
}