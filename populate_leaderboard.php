<?php

/**
 * Script untuk populate leaderboard data dari existing bookings
 * Run: php artisan tinker < populate_leaderboard.php
 */

use App\Models\User;
use App\Models\Booking;
use App\Models\UserStatistic;

echo "Starting leaderboard population...\n\n";

// Get all users
$users = User::all();
$totalUsers = $users->count();
$processedUsers = 0;

foreach ($users as $user) {
    echo "Processing user: {$user->name} (ID: {$user->id})\n";
    
    // Get or create user statistic
    $stat = $user->userStatistic;
    if (!$stat) {
        $stat = $user->userStatistic()->create([]);
        echo "  - Created new statistic record\n";
    }
    
    // Count total bookings
    $totalBookings = $user->bookings()->count();
    
    // Count completed bookings (status: completed or checked_in)
    $completedBookings = $user->bookings()
        ->whereIn('status', ['completed', 'checked_in'])
        ->count();
    
    // Count cancelled bookings
    $cancelledBookings = $user->bookings()
        ->where('status', 'cancelled')
        ->count();
    
    // Calculate total spent (only paid, completed, checked_in)
    $totalSpent = $user->bookings()
        ->whereIn('status', ['paid', 'completed', 'checked_in'])
        ->sum('total_price');
    
    // Count unique mountains climbed
    $uniqueMountains = $user->bookings()
        ->whereIn('status', ['completed', 'checked_in'])
        ->distinct('mountain_id')
        ->count('mountain_id');
    
    // For monthly stats, count bookings from current month (January 2026)
    $monthlyBookings = $user->bookings()
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();
    
    $monthlyCompleted = $user->bookings()
        ->whereIn('status', ['completed', 'checked_in'])
        ->whereMonth('check_in_date', now()->month)
        ->whereYear('check_in_date', now()->year)
        ->count();
    
    $monthlySpent = $user->bookings()
        ->whereIn('status', ['paid', 'completed', 'checked_in'])
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_price');
    
    // Update statistics
    $stat->update([
        'total_bookings' => $totalBookings,
        'completed_bookings' => $completedBookings,
        'cancelled_bookings' => $cancelledBookings,
        'unique_mountains_climbed' => $uniqueMountains,
        'total_spent' => $totalSpent,
        'monthly_bookings' => $monthlyBookings,
        'monthly_completed' => $monthlyCompleted,
        'monthly_spent' => $monthlySpent,
        'last_reset_date' => now(),
    ]);
    
    echo "  - Total Bookings: {$totalBookings}\n";
    echo "  - Completed: {$completedBookings}\n";
    echo "  - Total Spent: Rp " . number_format($totalSpent, 0, ',', '.') . "\n";
    echo "  - Monthly Completed: {$monthlyCompleted}\n";
    echo "  ✓ Updated successfully!\n\n";
    
    $processedUsers++;
}

echo "═══════════════════════════════════════════════\n";
echo "Population completed!\n";
echo "Total users processed: {$processedUsers}/{$totalUsers}\n";
echo "═══════════════════════════════════════════════\n\n";

// Update rankings
echo "Updating rankings...\n";
app(App\Services\LeaderboardService::class)->updateRankings();
echo "✓ Rankings updated!\n\n";

// Clear cache
echo "Clearing cache...\n";
Cache::forget('leaderboard_monthly_' . now()->format('Y_m'));
Cache::forget('leaderboard_alltime');
echo "✓ Cache cleared!\n\n";

// Show summary
$stats = app(App\Services\LeaderboardService::class)->getStatistics();
echo "═══════════════════════════════════════════════\n";
echo "LEADERBOARD SUMMARY:\n";
echo "═══════════════════════════════════════════════\n";
echo "Total Climbers: {$stats['total_climbers']}\n";
echo "Active This Month: {$stats['active_this_month']}\n";
echo "Total Hikes Completed: {$stats['total_hikes_completed']}\n";
echo "Monthly Hikes: {$stats['total_hikes_this_month']}\n";
echo "═══════════════════════════════════════════════\n\n";

echo "Done! Visit /leaderboard to see the results.\n";
