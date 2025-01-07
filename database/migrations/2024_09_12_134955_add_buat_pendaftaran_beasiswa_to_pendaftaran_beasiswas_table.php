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
            $table->foreignId('buat_pendaftaran_beasiswa_id') // Menambahkan foreign key untuk relasi
            ->constrained('buat_pendaftaran_beasiswas') // Mengacu pada tabel buat_pendaftaran_beasiswas
            ->onDelete('cascade'); // Jika beasiswa dihapus, pendaftaran juga terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_beasiswas', function (Blueprint $table) {
            $table->dropColumn('buat_pendaftaran_beasiswa_id');
        });
    }
};
