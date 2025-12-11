<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mountain;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 1. Revenue Trends (6 months)
        $revenueTrends = $this->getRevenueTrends();
        
        // 2. Booking Status Distribution
        $bookingStatus = $this->getBookingStatusDistribution();
        
        // 3. Mountain Popularity (Top 10)
        $mountainPopularity = $this->getMountainPopularity();
        
        // 4. Summary Stats
        $stats = $this->getSummaryStats();
        
        return view('admin.analytics.index', compact(
            'revenueTrends',
            'bookingStatus',
            'mountainPopularity',
            'stats'
        ));
    }
    
    /**
     * Get revenue trends for last 6 months
     */
    private function getRevenueTrends()
    {
        $months = [];
        $revenues = [];
        
        // Get last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            
            // Get revenue for this month
            $revenue = Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereIn('status', ['paid', 'checked_in', 'completed'])
                ->sum('total_price');
            
            $months[] = $date->format('M Y'); // "Jan 2025"
            $revenues[] = (int) $revenue;
        }
        
        return [
            'labels' => $months,
            'data' => $revenues
        ];
    }
    
    /**
     * Get booking status distribution
     */
    private function getBookingStatusDistribution()
    {
        $statusCounts = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Ensure all statuses are present
        $allStatuses = ['pending', 'paid', 'checked_in', 'completed', 'cancelled'];
        $labels = [];
        $data = [];
        
        foreach ($allStatuses as $status) {
            $labels[] = ucfirst(str_replace('_', ' ', $status));
            $data[] = $statusCounts[$status] ?? 0;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    /**
     * Get top 10 mountains by booking count
     */
    private function getMountainPopularity()
    {
        $mountains = Mountain::select('mountains.name', DB::raw('COUNT(bookings.id) as booking_count'))
            ->leftJoin('bookings', 'mountains.id', '=', 'bookings.mountain_id')
            ->groupBy('mountains.id', 'mountains.name')
            ->orderBy('booking_count', 'DESC')
            ->limit(10)
            ->get();
        
        $labels = [];
        $data = [];
        
        foreach ($mountains as $mountain) {
            $labels[] = $mountain->name;
            $data[] = (int) $mountain->booking_count;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    /**
     * Get summary statistics
     */
    private function getSummaryStats()
    {
        // Total Revenue (all time)
        $totalRevenue = Booking::whereIn('status', ['paid', 'checked_in', 'completed'])
            ->sum('total_price');
        
        // Total Bookings (all time)
        $totalBookings = Booking::count();
        
        // Active Mountains
        $activeMountains = Mountain::where('status', 'open')->count();
        
        // Average Booking Value
        $avgBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;
        
        // This month revenue
        $thisMonthRevenue = Booking::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereIn('status', ['paid', 'checked_in', 'completed'])
            ->sum('total_price');
        
        // Last month revenue
        $lastMonthRevenue = Booking::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereIn('status', ['paid', 'checked_in', 'completed'])
            ->sum('total_price');
        
        // Calculate percentage change
        $revenueChange = 0;
        if ($lastMonthRevenue > 0) {
            $revenueChange = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }
        
        return [
            'total_revenue' => $totalRevenue,
            'total_bookings' => $totalBookings,
            'active_mountains' => $activeMountains,
            'avg_booking_value' => $avgBookingValue,
            'revenue_change' => round($revenueChange, 1)
        ];
    }
}
