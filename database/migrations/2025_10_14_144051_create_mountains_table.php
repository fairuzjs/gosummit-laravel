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
        Schema::create('mountains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('location');
            $table->unsignedInteger('ticket_price')->default(0);
            $table->unsignedInteger('daily_quota')->default(100);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->string('image_url')->nullable(); // <-- Kolom gambar ditambahkan di sini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mountains');
    }
};