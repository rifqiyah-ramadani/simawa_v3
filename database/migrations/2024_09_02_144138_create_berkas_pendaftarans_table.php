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
        Schema::create('berkas_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file'); // Nama file yang diperlukan
            $table->string('keterangan')->nullable();  // Keterangan tambahan, jika diperlukan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_pendaftarans');
    }
};
