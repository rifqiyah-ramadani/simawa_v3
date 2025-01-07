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
        Schema::table('validasi_pendaftaran_beasiswas', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->change(); // Mengubah role_id menjadi nullable
            $table->integer('urutan')->nullable()->change(); // Mengubah urutan menjadi nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('validasi_pendaftaran_beasiswas', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable(false)->change(); // Kembalikan ke kondisi awal
            $table->integer('urutan')->nullable(false)->change(); // Kembalikan ke kondisi awal
        });
    }
};
