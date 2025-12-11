<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingMember extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara manual
    protected $table = 'booking_members';

    protected $fillable = [
        'booking_id',
        'full_name',
        'identity_number',
    ];

    /**
     * Relasi: Satu anggota ini dimiliki oleh satu Booking.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}