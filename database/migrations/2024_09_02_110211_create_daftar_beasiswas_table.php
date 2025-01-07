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
        Schema::create('daftar_beasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_beasiswa')->unique();  // Field untuk kode beasiswa, harus unik
            $table->string('nama_beasiswa');  // Field untuk nama beasiswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_beasiswas');
    }
};
