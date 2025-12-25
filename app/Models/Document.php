<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['registration_id', 'file_kk', 'file_ijazah_skl', 'file_akta', 'file_rapor_gabungan'];
}