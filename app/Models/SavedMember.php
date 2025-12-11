<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'id_number',
        'phone',
    ];

    /**
     * Get the user that owns the saved member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
