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
        Schema::create('berkas_pendaftaran_beasiswa', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('pendaftaran_id');
            $table->unsignedBigInteger('berkas_id');

            $table->foreign('pendaftaran_id', 'fk_pendaftaran_beasiswa')
                  ->references('id')
                  ->on('buat_pendaftaran_beasiswas')
                  ->onDelete('cascade');

            $table->foreign('berkas_id', 'fk_berkas')
                  ->references('id')
                  ->on('berkas_pendaftarans')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_pendaftaran_beasiswa');
    }
};
