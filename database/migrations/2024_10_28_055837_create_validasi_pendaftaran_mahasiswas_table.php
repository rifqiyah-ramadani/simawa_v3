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
        Schema::create('validasi_pendaftaran_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran_beasiswas')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles'); // Role yang akan melakukan validasi
            $table->string('status')->default('menunggu');  // Urutan validasi, 1 untuk yang pertama
            $table->integer('urutan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasi_pendaftaran_mahasiswas');
    }
};
