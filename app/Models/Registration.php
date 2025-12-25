<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id', 
        'nomor_pendaftaran', 
        'nama_lengkap', 
        'nisn', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'alamat', 
        'no_hp', 
        'asal_sekolah', 
        'major_id', 
        'foto', 
        'status_pendaftaran',
        'is_final'
    ];

    // Relasi ke User
    public function user() { return $this->belongsTo(User::class); }

    // Relasi ke Jurusan Pilihan
    public function major() { return $this->belongsTo(Major::class); }

    // Relasi ke Nilai
    public function grade() { return $this->hasOne(Grade::class); }

    // Relasi ke Dokumen
    public function documents() { return $this->hasOne(Document::class); }
}
