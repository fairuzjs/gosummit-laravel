<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrailRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'mountain_id',
        'name',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relasi
    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}