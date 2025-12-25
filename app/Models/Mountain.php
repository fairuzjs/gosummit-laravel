<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'ticket_price',
        'height',      // <--- WAJIB DITAMBAHKAN
        'daily_quota',
        'status',
        'image_url',
    ];

    /**
     * Relasi: Satu Gunung bisa memiliki banyak Booking.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi: Satu Gunung bisa memiliki banyak data Kuota.
     */
    public function quotas()
    {
        return $this->hasMany(Quota::class);
    }

    public function trailRoutes()
    {
        return $this->hasMany(TrailRoute::class);
    }
}