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
        Schema::table('kriterias', function (Blueprint $table) {
            $table->string('key_detail_user')->nullable()->after('nama_kriteria'); // Tambahkan kolom baru
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriterias', function (Blueprint $table) {
            $table->dropColumn('key_detail_user');
        });
    }
};
