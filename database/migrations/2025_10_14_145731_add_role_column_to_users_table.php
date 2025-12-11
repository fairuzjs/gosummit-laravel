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
        // Instruksi untuk mengubah tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'role' dengan tipe ENUM setelah kolom 'password'
            $table->enum('role', ['admin', 'user'])->after('password')->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Instruksi untuk membatalkan (jika diperlukan)
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};