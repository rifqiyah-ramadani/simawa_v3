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
        Schema::create('validasi_pendaftaran_beasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('buat_pendaftaran_beasiswas')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Role yang akan melakukan validasi
            $table->integer('urutan')->default(1); // Urutan validasi, 1 untuk yang pertama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi_pendaftaran_beasiswas');
    }
};
