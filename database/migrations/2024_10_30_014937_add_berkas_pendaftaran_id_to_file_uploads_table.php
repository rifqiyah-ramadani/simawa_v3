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
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->unsignedBigInteger('berkas_pendaftaran_id')->nullable()->after('pendaftaran_beasiswas_id');

            $table->foreign('berkas_pendaftaran_id')
                ->references('id')
                ->on('berkas_pendaftarans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_uploads', function (Blueprint $table) {
            // Drop foreign key dan kolom jika migrasi di-rollback
            $table->dropForeign(['berkas_pendaftaran_id']);
            $table->dropColumn('berkas_pendaftaran_id');
        });
    }
};
