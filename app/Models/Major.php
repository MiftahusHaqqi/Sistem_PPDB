<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['nama_jurusan', 'kuota'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
