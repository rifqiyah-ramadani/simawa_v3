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
        Schema::table('persyaratan_beasiswas', function (Blueprint $table) {
            $table->foreignId('kriteria_id')
                    ->nullable()
                    ->after('type') // Menempatkan kolom ini setelah kolom 'type'
                    ->constrained('kriterias')
                    ->onDelete('cascade'); // Relasi ke tabel kriteria // Contoh: 'IPK', 'program_reguler', 'umur'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persyaratan_beasiswas', function (Blueprint $table) {
            $table->dropForeign(['kriteria_id']);
            $table->dropColumn('kriteria_id');
        });
    }
};
