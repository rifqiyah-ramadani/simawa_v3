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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran_beasiswas')->onDelete('cascade');
            $table->date('tanggal_mulai'); // Tanggal mulai wawancara
            $table->date('tanggal_akhir')->nullable(); // Tanggal akhir wawancara, bisa null jika hanya satu hari
            $table->time('jam_wawancara'); // Jam wawancara
            $table->string('lokasi')->nullable(); // Lokasi wawancara
            $table->json('pewawancara_ids'); // Array JSON untuk menyimpan ID pewawancara
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
