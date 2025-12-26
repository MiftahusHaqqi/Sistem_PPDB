<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Grade;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    /**
     * Menampilkan Dashboard Siswa
     */
    public function index()
    {
        // Menggunakan with('grade') agar data nilai ikut terambil
        $pendaftaran = Registration::with('grade')->where('user_id', Auth::id())->first();

        return view('siswa.dashboard', compact('pendaftaran'));
    }

    /**
     * Menampilkan Form Pendaftaran
     */
    public function pendaftaran()
    {
        $user = Auth::user();
        $pendaftaran = Registration::where('user_id', $user->id)->first();

        // Kita juga butuh data jurusan untuk isi dropdown di form
        $jurusan = \App\Models\Major::all();

        return view('siswa.pendaftaran', compact('pendaftaran', 'jurusan'));
    }

    /**
     * Menampilkan Status Kelulusan
     */
    public function status()
    {
        $pendaftaran = Registration::where('user_id', Auth::id())->first();

        return view('siswa.status', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $existingRegistration = Registration::where('user_id', Auth::id())->first();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|numeric|digits:10|unique:registrations,nisn,' . ($existingRegistration->id ?? 'NULL') . ',id',

            'sem1' => 'required|numeric|min:0|max:100',
            'sem2' => 'required|numeric|min:0|max:100',
            'sem3' => 'required|numeric|min:0|max:100',
            'sem4' => 'required|numeric|min:0|max:100',
            'sem5' => 'required|numeric|min:0|max:100',

            'foto' => $existingRegistration
                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                : 'required|image|mimes:jpeg,png,jpg|max:2048',

            'major_id' => 'required|exists:majors,id',

            'file_kk' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah_skl' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_akta' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_rapor_gabungan' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        DB::beginTransaction();

        try {
            $rataRata = collect([
                $request->sem1,
                $request->sem2,
                $request->sem3,
                $request->sem4,
                $request->sem5,
            ])->avg();

            // Pastikan folder ada
            if (!file_exists(public_path('uploads/foto'))) {
                mkdir(public_path('uploads/foto'), 0755, true);
            }
            if (!file_exists(public_path('uploads/documents'))) {
                mkdir(public_path('uploads/documents'), 0755, true);
            }

            // FOTO
            $fotoPath = $existingRegistration->foto ?? null;
            if ($request->hasFile('foto')) {
                $namaFile = 'foto_' . $request->nisn . '_' . time() . '.' . $request->foto->extension();
                $request->foto->move(public_path('uploads/foto'), $namaFile);
                $fotoPath = 'uploads/foto/' . $namaFile;
            }

            // REGISTRATION
            $registration = Registration::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'nomor_pendaftaran' => $existingRegistration->nomor_pendaftaran
                        ?? 'PPDB-' . date('Ymd') . '-' . Str::upper(Str::random(4)),
                    'nama_lengkap' => $request->nama_lengkap,
                    'nisn' => $request->nisn,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'asal_sekolah' => $request->asal_sekolah,
                    'major_id' => $request->major_id,
                    'foto' => $fotoPath,
                    'nilai_rata_rata' => $rataRata,
                    'status_pendaftaran' => $existingRegistration->status_pendaftaran ?? 'Belum Diverifikasi',
                ]
            );

            // GRADES
            Grade::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'sem1' => $request->sem1,
                    'sem2' => $request->sem2,
                    'sem3' => $request->sem3,
                    'sem4' => $request->sem4,
                    'sem5' => $request->sem5,
                    'rata_rata' => $rataRata,
                ]
            );

            // DOCUMENTS
            $doc = Document::firstOrCreate(
                ['registration_id' => $registration->id],
                [
                    'file_kk' => '-',
                    'file_ijazah_skl' => '-',
                    'file_akta' => '-',
                    'file_rapor_gabungan' => '-',
                ]
            );

            $files = ['file_kk', 'file_ijazah_skl', 'file_akta', 'file_rapor_gabungan'];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    if ($doc->$file && $doc->$file != '-' && file_exists(public_path($doc->$file))) {
                        unlink(public_path($doc->$file));
                    }

                    $namaFile = $file . '_' . $request->nisn . '_' . time() . '.' . $request->file($file)->extension();
                    $request->file($file)->move(public_path('uploads/documents'), $namaFile);
                    $doc->$file = 'uploads/documents/' . $namaFile;
                }
            }

            $doc->save();

            DB::commit();
            return redirect()->route('siswa.dashboard')->with('success', 'Data pendaftaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function cetakBukti()
    {
        $pendaftaran = Registration::where('user_id', Auth::id())->first();

        // Pastikan siswa hanya bisa cetak jika sudah Lulus dan Final
        if (!$pendaftaran || !$pendaftaran->is_final || $pendaftaran->status_pendaftaran != 'Terverifikasi') {
            return redirect()->back()->with('error', 'Bukti kelulusan belum tersedia.');
        }

        $pdf = Pdf::loadView('siswa.cetak_pdf', compact('pendaftaran'));

        // Download file dengan nama 'Bukti_Lulus_NamaSiswa.pdf'
        return $pdf->stream('Bukti_Lulus_' . $pendaftaran->nama_lengkap . '.pdf');
    }
}
