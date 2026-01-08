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
        Schema::create('user_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Booking statistics
            $table->integer('total_bookings')->default(0);
            $table->integer('completed_bookings')->default(0);
            $table->integer('cancelled_bookings')->default(0);
            
            // Mountain statistics
            $table->integer('unique_mountains_climbed')->default(0);
            $table->decimal('total_spent', 15, 2)->default(0);
            
            // Monthly statistics (for leaderboard)
            $table->integer('monthly_bookings')->default(0);
            $table->integer('monthly_completed')->default(0);
            $table->decimal('monthly_spent', 15, 2)->default(0);
            $table->date('last_reset_date')->nullable();
            
            // Ranking
            $table->integer('overall_rank')->nullable();
            $table->integer('monthly_rank')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('overall_rank');
            $table->index('monthly_rank');
            $table->index(['monthly_completed', 'monthly_spent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_statistics');
    }
};
