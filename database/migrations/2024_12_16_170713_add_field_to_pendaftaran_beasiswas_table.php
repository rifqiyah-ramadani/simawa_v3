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
            $table->float('biaya_hidup', 15, 2)->nullable();
            $table->float('biaya_ukt', 15, 2)->nullable();
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
