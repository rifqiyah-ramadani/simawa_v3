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
        Schema::create('buat_pendaftaran_beasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignID('daftar_beasiswas_id')->constrained('daftar_beasiswas')->onDelete('cascade'); // Relasi ke tabel daftar_beasiswa 
            $table->year('tahun');  // field tahun
            $table->date('tanggal_mulai');  // Tanggal mulai pendaftaran
            $table->date('tanggal_berakhir');  // Tanggal berakhir pendaftaran
            $table->enum('status', ['dibuka', 'ditutup'])->default('dibuka');  // Status pendaftaran dibuka atau ditutup
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buat_pendaftaran_beasiswas'); 
    }
};
