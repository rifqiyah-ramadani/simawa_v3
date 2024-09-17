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
        Schema::create('persyaratan_beasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_persyaratan');  // Field untuk deskripsi persyaratan
            $table->text('keterangan')->nullable();  // Field untuk keterangan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratan_beasiswas');
    }
};
