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
}