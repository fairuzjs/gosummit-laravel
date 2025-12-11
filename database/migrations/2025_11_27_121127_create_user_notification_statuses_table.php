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
        Schema::create('user_notification_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('notification_id')->constrained('notifications')->onDelete('cascade');
            
            // Kolom baru untuk menandai status
            $table->boolean('is_deleted')->default(false); 

            $table->timestamps();
            
            // Memastikan satu notifikasi hanya bisa memiliki satu status per user
            $table->unique(['user_id', 'notification_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notification_statuses');
    }
};