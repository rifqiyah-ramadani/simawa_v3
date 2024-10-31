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
        Schema::table('pendaftaran_beasiswas', function (Blueprint $table) {
            $table->enum('status', ['menunggu', 'diproses', 'lulus seleksi administrasi', 'lulus seleksi wawancara', 'lulus seleksi tertulis', 'lulus semua tahapan', 'ditolak'])->default('menunggu')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_beasiswas', function (Blueprint $table) {
            //
        });
    }
};
