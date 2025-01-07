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
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom email dan email_verified_at
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kembali kolom email dan email_verified_at jika rollback
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};
