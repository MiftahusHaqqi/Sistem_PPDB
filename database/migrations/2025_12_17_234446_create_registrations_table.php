<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('registrations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('nomor_pendaftaran')->unique(); // Contoh: PPDB-2024-001
    $table->string('nama_lengkap');
    $table->string('nisn', 10)->unique();
    $table->string('tempat_lahir');
    $table->date('tanggal_lahir');
    $table->enum('jenis_kelamin', ['L', 'P']);
    $table->text('alamat');
    $table->string('no_hp')->nullable();
    $table->string('asal_sekolah');
    $table->foreignId('major_id')->constrained(); // Pilihan Jurusan
    $table->string('foto')->nullable();
    
    // Status Pendaftaran
    $table->enum('status_pendaftaran', ['Belum Diverifikasi', 'Terverifikasi', 'Lulus', 'Tidak Lulus'])->default('Belum Diverifikasi');
    $table->foreignId('accepted_major_id')->nullable()->constrained('majors'); // Jurusan jika lulus
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
