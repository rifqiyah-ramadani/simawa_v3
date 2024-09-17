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
        Schema::create('persyaratan_pendaftaran_beasiswa', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('pendaftaran_id');
            $table->unsignedBigInteger('persyaratan_id');

            $table->foreign('pendaftaran_id', 'fk_pendaftaran')
                  ->references('id')
                  ->on('buat_pendaftaran_beasiswas')
                  ->onDelete('cascade');

            $table->foreign('persyaratan_id', 'fk_persyaratan')
                  ->references('id')
                  ->on('persyaratan_beasiswas')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratan_pendaftaran_beasiswa');
    }
};
