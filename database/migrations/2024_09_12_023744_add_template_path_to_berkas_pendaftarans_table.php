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
        Schema::table('berkas_pendaftarans', function (Blueprint $table) {
            $table->string('template_path')->nullable();  // Kolom untuk menyimpan path template file
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_pendaftarans', function (Blueprint $table) {
            $table->dropColumn('template_path');
        });
    }
};
