<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_bookings',
        'completed_bookings',
        'cancelled_bookings',
        'unique_mountains_climbed',
        'total_spent',
        'monthly_bookings',
        'monthly_completed',
        'monthly_spent',
        'last_reset_date',
        'overall_rank',
        'monthly_rank',
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'monthly_spent' => 'decimal:2',
        'last_reset_date' => 'date',
    ];

    /**
     * Get the user that owns the statistics.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Increment booking count
     */
    public function incrementBooking($amount = 0)
    {
        $this->increment('total_bookings');
        $this->increment('monthly_bookings');
        
        if ($amount > 0) {
            $this->increment('total_spent', $amount);
            $this->increment('monthly_spent', $amount);
        }
        
        $this->save();
    }

    /**
     * Increment completed booking
     */
    public function incrementCompleted()
    {
        $this->increment('completed_bookings');
        $this->increment('monthly_completed');
        $this->save();
    }

    /**
     * Increment cancelled booking
     */
    public function incrementCancelled()
    {
        $this->increment('cancelled_bookings');
        $this->save();
    }

    /**
     * Reset monthly statistics
     */
    public function resetMonthly()
    {
        $this->update([
            'monthly_bookings' => 0,
            'monthly_completed' => 0,
            'monthly_spent' => 0,
            'last_reset_date' => now(),
        ]);
    }

    /**
     * Check if monthly stats need reset
     */
    public function shouldResetMonthly()
    {
        if (!$this->last_reset_date) {
            return true;
        }

        return $this->last_reset_date->month !== now()->month;
    }
}
