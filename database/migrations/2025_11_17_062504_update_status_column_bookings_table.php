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
        Schema::table('bookings', function (Blueprint $table) {
            // Mengubah tipe kolom status menjadi VARCHAR(20)
            $table->string('status', 20)->change(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Mengembalikan ke panjang sebelumnya (misalnya 9 atau 10)
            $table->string('status', 9)->change(); 
        });
    }
};
