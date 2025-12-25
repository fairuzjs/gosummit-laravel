<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;

    protected $fillable = [
        'mountain_id',
        'date',
        'remaining_quota',
    ];

    /**
     * Relasi: Satu data kuota ini dimiliki oleh satu Mountain.
     */
    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }
}