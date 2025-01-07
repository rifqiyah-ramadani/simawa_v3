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
            // Hapus kolom fakultas lama
            $table->dropColumn('fakultas');
            $table->unsignedBigInteger('fakultas_id')->after('nim')->nullable();

            // Menambahkan foreign key jika tabel fakultas sudah ada
            $table->foreign('fakultas_id')->references('id')->on('fakultas')->onDelete('set null');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_beasiswas', function (Blueprint $table) {
            // Hapus foreign key dan kolom fakultas_id
            $table->dropForeign(['fakultas_id']);
            $table->dropColumn('fakultas_id');

            // Kembalikan kolom fakultas lama
            $table->string('fakultas')->nullable();
        });
    }
};
