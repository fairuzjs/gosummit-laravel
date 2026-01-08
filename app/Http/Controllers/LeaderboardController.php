<?php

namespace App\Http\Controllers;

use App\Services\LeaderboardService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    protected $leaderboardService;

    public function __construct(LeaderboardService $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }

    /**
     * Display the leaderboard page
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'monthly'); // monthly or alltime

        if ($type === 'alltime') {
            $leaderboard = $this->leaderboardService->getAllTimeLeaderboard(50);
            $userRank = auth()->check() 
                ? $this->leaderboardService->getUserAllTimeRank(auth()->id()) 
                : null;
        } else {
            $leaderboard = $this->leaderboardService->getMonthlyLeaderboard(50);
            $userRank = auth()->check() 
                ? $this->leaderboardService->getUserMonthlyRank(auth()->id()) 
                : null;
        }

        $statistics = $this->leaderboardService->getStatistics();

        return view('leaderboard.index', compact('leaderboard', 'type', 'userRank', 'statistics'));
    }

    /**
     * Get leaderboard data for AJAX
     */
    public function getData(Request $request)
    {
        $type = $request->get('type', 'monthly');
        $limit = $request->get('limit', 10);

        if ($type === 'alltime') {
            $leaderboard = $this->leaderboardService->getAllTimeLeaderboard($limit);
        } else {
            $leaderboard = $this->leaderboardService->getMonthlyLeaderboard($limit);
        }

        return response()->json([
            'success' => true,
            'data' => $leaderboard,
        ]);
    }

    /**
     * Get user details for modal popup
     */
    public function getUserDetails($userId)
    {
        try {
            $user = \App\Models\User::with(['bookings' => function($query) {
                $query->whereIn('status', ['completed', 'checked_in'])
                      ->with('mountain:id,name,location,image_url')
                      ->orderBy('check_in_date', 'desc');
            }, 'userStatistic'])
            ->findOrFail($userId);

            // Group bookings by mountain and count frequency
            $mountainCounts = $user->bookings
                ->filter(function($booking) {
                    return $booking->mountain !== null;
                })
                ->groupBy('mountain_id')
                ->map(function($bookings) {
                    $mountain = $bookings->first()->mountain;
                    return [
                        'name' => $mountain->name,
                        'location' => $mountain->location,
                        'image' => $mountain->image_url ?? 'default-mountain.jpg',
                        'count' => $bookings->count(), // Jumlah kali mendaki
                        'last_climb' => $bookings->max('check_in_date'),
                        'status' => $bookings->first()->status,
                    ];
                })
                ->sortByDesc('count') // Sort by most climbed
                ->values();

            // Check privacy settings for email
            $email = $user->shouldShowEmail() 
                ? $user->email 
                : mask_email($user->email);

            // Check privacy settings for total spent
            $totalSpent = $user->shouldShowTotalSpent() 
                ? ($user->userStatistic->total_spent ?? 0)
                : null;

            // Check privacy settings for mountain history
            $mountains = $user->shouldShowMountainHistory() 
                ? $mountainCounts 
                : [];

            return response()->json([
                'success' => true,
                'user' => [
                    'name' => $user->name,
                    'email' => $email,
                    'completed_bookings' => $user->userStatistic->completed_bookings ?? 0,
                    'total_spent' => $totalSpent,
                    'show_total_spent' => $user->shouldShowTotalSpent(),
                    'show_mountain_history' => $user->shouldShowMountainHistory(),
                ],
                'mountains' => $mountains,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching user details: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load user details',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
