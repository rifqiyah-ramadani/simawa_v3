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
            $table->string('kriteria');  // Contoh: 'IPK', 'program_reguler', 'umur'
            $table->string('operator');  // Contoh: '>=', '=', '!='
            $table->string('value');     // Contoh: '3.00', 'S1', '23'
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
