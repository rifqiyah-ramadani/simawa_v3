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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Menambahkan kolom flyer yang nullable
            $table->string('IPK')->after('jurusan');
            $table->string('semester')->after('IPK');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_beasiswas', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('IPK');
            $table->dropColumn('semester');
        });
    }
};
