<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    $this->call([
        MajorSeeder::class,
    ]);
    User::create([
    'name' => 'Admin Panitia',
    'email' => 'admin@gmail.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
    ]);

    User::create([
        'name' => 'Siswa Dummy',
        'email' => 'siswa@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'siswa'
    ]);
    }
}
