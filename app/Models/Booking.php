<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookingMember;
use App\Models\Mountain;
use App\Models\TrailRoute;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'mountain_id',
        'trail_route_id', // Nama kolom yang benar sesuai migrasi
        'check_in_date',
        'check_out_date',
        'member_count',
        'total_price',
        'status',
        'booking_code',
        'midtrans_order_id', // Pastikan ini ada untuk pembayaran
    ];

    /**
     * Relasi: Satu Booking dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Booking dimiliki oleh satu Mountain.
     */
    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    /**
     * Relasi: Satu Booking memiliki satu Jalur Pendakian.
     */
    public function trailRoute()
    {
        return $this->belongsTo(TrailRoute::class);
    }

    /**
     * Relasi: Satu Booking memiliki banyak Anggota Rombongan.
     */
    public function members()
    {
        return $this->hasMany(BookingMember::class);
    }

    /**
     * The "booted" method of the model.
     * Auto-update user statistics for leaderboard
     */
    protected static function booted()
    {
        // Event: Setelah booking dibuat
        static::created(function ($booking) {
            if ($booking->user) {
                $stat = $booking->user->getStatistic();
                
                // Increment total bookings
                $stat->increment('total_bookings');
                
                // Update total spent jika status paid/completed
                if (in_array($booking->status, ['paid', 'completed', 'checked_in'])) {
                    $stat->increment('total_spent', $booking->total_price);
                }
                
                // Clear cache
                static::clearLeaderboardCache();
            }
        });

        // Event: Setelah booking diupdate
        static::updated(function ($booking) {
            if ($booking->user) {
                $stat = $booking->user->getStatistic();
                
                // Jika status berubah menjadi completed atau checked_in
                if (in_array($booking->status, ['completed', 'checked_in'])) {
                    // Cek apakah status baru saja berubah (sebelumnya bukan completed/checked_in)
                    $oldStatus = $booking->getOriginal('status');
                    if (!in_array($oldStatus, ['completed', 'checked_in'])) {
                        // Increment completed bookings
                        $stat->increment('completed_bookings');
                        
                        // Update monthly completed jika bulan ini
                        if ($booking->check_in_date && 
                            \Carbon\Carbon::parse($booking->check_in_date)->isCurrentMonth()) {
                            $stat->increment('monthly_completed');
                        }
                    }
                }
                
                // Jika status berubah ke paid/completed/checked_in, update total spent
                if (in_array($booking->status, ['paid', 'completed', 'checked_in'])) {
                    $oldStatus = $booking->getOriginal('status');
                    if (!in_array($oldStatus, ['paid', 'completed', 'checked_in'])) {
                        $stat->increment('total_spent', $booking->total_price);
                        
                        // Update monthly spent jika bulan ini
                        if (\Carbon\Carbon::parse($booking->created_at)->isCurrentMonth()) {
                            $stat->increment('monthly_spent', $booking->total_price);
                        }
                    }
                }
                
                // Clear cache
                static::clearLeaderboardCache();
            }
        });
    }

    /**
     * Clear leaderboard cache
     */
    protected static function clearLeaderboardCache()
    {
        \Cache::forget('leaderboard_alltime_5');
        \Cache::forget('leaderboard_alltime_10');
        \Cache::forget('leaderboard_alltime_50');
        \Cache::forget('leaderboard_monthly_' . now()->format('Y_m'));
    }
}