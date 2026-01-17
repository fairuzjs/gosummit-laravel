<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserStatistic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class LeaderboardService
{
    /**
     * Get monthly leaderboard
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMonthlyLeaderboard($limit = 10)
    {
        return Cache::remember('leaderboard_monthly_' . now()->format('Y_m'), 300, function () use ($limit) {
            return User::with('userStatistic')
                ->whereHas('userStatistic', function($query) {
                    $query->where('monthly_completed', '>', 0);
                })
                ->join('user_statistics', 'users.id', '=', 'user_statistics.user_id')
                ->select('users.*')
                ->where('user_statistics.monthly_completed', '>', 0)
                ->orderByDesc('user_statistics.monthly_completed')
                ->orderByDesc('user_statistics.monthly_spent')
                ->limit($limit)
                ->get()
                ->filter(function($user) {
                    return $user->userStatistic !== null;
                })
                ->map(function($user) {
                    // Apply privacy settings for total spent
                    if (!$user->shouldShowTotalSpent()) {
                        $user->userStatistic->monthly_spent = null;
                    }
                    // Apply privacy settings for email
                    if (!$user->shouldShowEmail()) {
                        $user->masked_email = mask_email($user->email);
                    } else {
                        $user->masked_email = $user->email;
                    }
                    return $user;
                });
        });
    }

    /**
     * Get all-time leaderboard
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTimeLeaderboard($limit = 10)
    {
        return Cache::remember('leaderboard_alltime_' . $limit, 300, function () use ($limit) {
            return User::with('userStatistic')
                ->whereHas('userStatistic', function($query) {
                    $query->where('completed_bookings', '>', 0);
                })
                ->join('user_statistics', 'users.id', '=', 'user_statistics.user_id')
                ->select('users.*')
                ->where('user_statistics.completed_bookings', '>', 0)
                ->orderByDesc('user_statistics.completed_bookings')
                ->orderByDesc('user_statistics.total_spent')
                ->limit($limit)
                ->get()
                ->filter(function($user) {
                    return $user->userStatistic !== null;
                })
                ->map(function($user) {
                    // Apply privacy settings for total spent
                    if (!$user->shouldShowTotalSpent()) {
                        $user->userStatistic->total_spent = null;
                    }
                    // Apply privacy settings for email
                    if (!$user->shouldShowEmail()) {
                        $user->masked_email = mask_email($user->email);
                    } else {
                        $user->masked_email = $user->email;
                    }
                    return $user;
                })
                ->take($limit); // Ensure exact limit after filter
        });
    }

    /**
     * Get user rank in monthly leaderboard
     * 
     * @param int $userId
     * @return int|null
     */
    public function getUserMonthlyRank($userId)
    {
        $rank = UserStatistic::where('monthly_completed', '>', 0)
            ->orderByDesc('monthly_completed')
            ->orderByDesc('monthly_spent')
            ->pluck('user_id')
            ->search($userId);

        return $rank !== false ? $rank + 1 : null;
    }

    /**
     * Get user rank in all-time leaderboard
     * 
     * @param int $userId
     * @return int|null
     */
    public function getUserAllTimeRank($userId)
    {
        $rank = UserStatistic::where('completed_bookings', '>', 0)
            ->orderByDesc('completed_bookings')
            ->orderByDesc('total_spent')
            ->pluck('user_id')
            ->search($userId);

        return $rank !== false ? $rank + 1 : null;
    }

    /**
     * Update rankings for all users
     */
    public function updateRankings()
    {
        // Update monthly rankings
        $monthlyUsers = UserStatistic::where('monthly_completed', '>', 0)
            ->orderByDesc('monthly_completed')
            ->orderByDesc('monthly_spent')
            ->get();

        foreach ($monthlyUsers as $index => $stat) {
            $stat->update(['monthly_rank' => $index + 1]);
        }

        // Update overall rankings
        $allTimeUsers = UserStatistic::where('completed_bookings', '>', 0)
            ->orderByDesc('completed_bookings')
            ->orderByDesc('total_spent')
            ->get();

        foreach ($allTimeUsers as $index => $stat) {
            $stat->update(['overall_rank' => $index + 1]);
        }

        // Clear cache
        Cache::forget('leaderboard_monthly_' . now()->format('Y_m'));
        Cache::forget('leaderboard_alltime');
    }

    /**
     * Reset monthly statistics for all users
     */
    public function resetMonthlyStats()
    {
        UserStatistic::query()->update([
            'monthly_bookings' => 0,
            'monthly_completed' => 0,
            'monthly_spent' => 0,
            'monthly_rank' => null,
            'last_reset_date' => now(),
        ]);

        Cache::forget('leaderboard_monthly_' . now()->format('Y_m'));
    }

    /**
     * Get leaderboard statistics
     */
    public function getStatistics()
    {
        return [
            'total_climbers' => UserStatistic::where('completed_bookings', '>', 0)->count(),
            'active_this_month' => UserStatistic::where('monthly_completed', '>', 0)->count(),
            'total_hikes_completed' => UserStatistic::sum('completed_bookings'),
            'total_hikes_this_month' => UserStatistic::sum('monthly_completed'),
        ];
    }
}