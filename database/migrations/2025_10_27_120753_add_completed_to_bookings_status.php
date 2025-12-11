<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah kolom status untuk menambahkan 'completed'
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'paid', 'failed', 'canceled', 'completed') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke kondisi sebelumnya
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'paid', 'failed', 'canceled') DEFAULT 'pending'");
    }
};