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
        Schema::create('pendaftaran_tahapan_beasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_beasiswa_id')->constrained('buat_pendaftaran_beasiswas')->onDelete('cascade');
            $table->foreignId('tahapan_beasiswa_id')->constrained('tahapan_beasiswas')->onDelete('cascade');
            $table->date('tanggal_mulai'); // Tanggal mulai tahapan
            $table->date('tanggal_akhir'); // Tanggal akhir tahapan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_tahapan_beasiswa');
    }
};
