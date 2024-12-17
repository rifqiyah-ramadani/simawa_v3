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
        Schema::create('data_penerimas', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel pendaftaran_beasiswas
            $table->foreignId('pendaftaran_beasiswa_id')
                ->constrained('pendaftaran_beasiswas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->enum('status_penerima', ['sedang menerima', 'masa selesai'])->nullable();  // Enum untuk status penerima
            $table->string('start_semester')->nullable(); //
            $table->string('end_semester')->nullable(); // Semester akhir penerimaan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_penerimas');
    }
};
