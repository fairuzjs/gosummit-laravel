<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture',
        'phone',
        'identity_number',
        'leaderboard_privacy',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'leaderboard_privacy' => 'array',
    ];

    // DEFINISI RELASI: Satu User bisa memiliki banyak Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // DEFINISI RELASI: Satu User bisa memiliki banyak Saved Member (max 5)
    public function savedMembers()
    {
        return $this->hasMany(SavedMember::class);
    }

    // DEFINISI RELASI: Satu User memiliki satu User Statistic
    public function userStatistic()
    {
        return $this->hasOne(UserStatistic::class);
    }

    // DEFINISI RELASI: Satu User memiliki banyak Photos
    public function photos()
    {
        return $this->hasMany(UserPhoto::class)->orderBy('order');
    }

    /**
     * Get or create user statistic
     */
    public function getStatistic()
    {
        if (!$this->userStatistic) {
            $this->userStatistic()->create([]);
        }
        
        return $this->userStatistic;
    }

    /**
     * Get leaderboard privacy settings with defaults
     */
    public function getLeaderboardPrivacy()
    {
        $defaults = [
            'show_total_spent' => true,
            'show_mountain_history' => true,
            'show_email' => false,
        ];

        return array_merge($defaults, $this->leaderboard_privacy ?? []);
    }

    /**
     * Check if total spent should be visible
     */
    public function shouldShowTotalSpent()
    {
        $privacy = $this->getLeaderboardPrivacy();
        return $privacy['show_total_spent'] ?? true;
    }

    /**
     * Check if mountain history should be visible
     */
    public function shouldShowMountainHistory()
    {
        $privacy = $this->getLeaderboardPrivacy();
        return $privacy['show_mountain_history'] ?? true;
    }

    /**
     * Check if email should be visible
     */
    public function shouldShowEmail()
    {
        $privacy = $this->getLeaderboardPrivacy();
        return $privacy['show_email'] ?? false;
    }
}