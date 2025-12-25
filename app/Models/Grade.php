<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['registration_id', 'sem1', 'sem2', 'sem3', 'sem4', 'sem5', 'rata_rata'];

    // Boot function untuk menghitung rata-rata otomatis sebelum save
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($grade) {
            $grade->rata_rata = ($grade->sem1 + $grade->sem2 + $grade->sem3 + $grade->sem4 + $grade->sem5) / 5;
        });
    }
}
