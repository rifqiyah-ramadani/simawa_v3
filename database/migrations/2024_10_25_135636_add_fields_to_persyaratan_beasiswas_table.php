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
            $table->enum('type', ['tanpa_kriteria', 'dengan_kriteria'])
                  ->default('tanpa_kriteria'); // Type menentukan apakah persyaratan memakai kriteria
            $table->enum('operator', ['>=', '<=', '=', '<', '>', '!='])->nullable();  // Contoh: '>=', '=', '!='
            $table->json('value')->nullable();  // Value kriteria (bisa teks, angka, atau opsi) Contoh: '3.00', 'S1', '23'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persyaratan_beasiswas', function (Blueprint $table) {
            $table->dropColumn('kriteria');
            $table->dropColumn('operator');
            $table->dropColumn('value');
        });
    }
};
