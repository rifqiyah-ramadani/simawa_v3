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
        Schema::create('pendaftaran_beasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap'); // Nama lengkap mahasiswa
            $table->string('nim'); // NIM mahasiswa
            $table->string('fakultas'); // Fakultas mahasiswa
            $table->string('jurusan'); // Jurusan mahasiswa
            $table->text('alamat_lengkap'); // Alamat lengkap sesuai KTP
            $table->string('telepon'); // Nomor telepon mahasiswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_beasiswas');
    }
};
