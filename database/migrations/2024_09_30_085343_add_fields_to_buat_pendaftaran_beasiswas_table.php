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
        Schema::table('buat_pendaftaran_beasiswas', function (Blueprint $table) {
            // Menambahkan kolom jenis_beasiswa tipe ENUM
            $table->enum('jenis_beasiswa', ['internal', 'eksternal'])->after('daftar_beasiswas_id');

            // Menambahkan kolom flyer yang nullable
            $table->string('flyer')->nullable()->after('status');

            // Menambahkan kolom link_pendaftaran yang nullable
            $table->string('link_pendaftaran')->nullable()->after('flyer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buat_pendaftaran_beasiswas', function (Blueprint $table) {
            // Menghapus kolom jika rollback
            $table->dropColumn(['jenis_beasiswa', 'flyer', 'link_pendaftaran']);
        });
    }
};
