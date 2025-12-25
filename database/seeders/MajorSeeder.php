<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run()
    {
        // Gunakan create agar created_at terisi otomatis
        Major::create(['nama_jurusan' => 'IPA', 'kuota' => 100]);
        Major::create(['nama_jurusan' => 'IPS', 'kuota' => 100]);
        Major::create(['nama_jurusan' => 'Bahasa', 'kuota' => 50]);
    }
}
