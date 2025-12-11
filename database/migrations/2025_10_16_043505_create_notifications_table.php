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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul notifikasi, misal: "Perubahan Jadwal"
            $table->text('message'); // Isi pesan notifikasi
            $table->enum('type', ['info', 'warning', 'promo'])->default('info'); // Jenis notifikasi untuk styling
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};