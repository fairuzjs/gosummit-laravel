<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'usage_limit',
        'used_count',
        'user_usage_limit',
        'created_by',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    // Cek apakah voucher masih aktif
    public function isActive()
    {
        $now = now();
        if ($this->valid_from && $now < $this->valid_from) {
            return false;
        }
        if ($this->valid_until && $now > $this->valid_until) {
            return false;
        }
        if ($this->usage_limit > 0 && $this->used_count >= $this->usage_limit) {
            return false;
        }
        return true;
    }

    // Cek apakah voucher bisa digunakan oleh user tertentu
    public function canBeUsedBy($user)
    {
        if (!$this->isActive()) {
            return false;
        }

        // Hitung jumlah penggunaan voucher ini oleh user ini
        $userUsageCount = $this->voucherUsages()
                                ->where('user_id', $user->id)
                                ->count();

        if ($this->user_usage_limit > 0 && $userUsageCount >= $this->user_usage_limit) {
            return false;
        }

        return true;
    }

    // Relasi dengan penggunaan voucher
    public function voucherUsages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    // Hitung nilai diskon berdasarkan total harga
    public function calculateDiscount($totalPrice)
    {
        if ($this->type === 'percentage') {
            return ($this->value / 100) * $totalPrice;
        } else { // fixed
            return min($this->value, $totalPrice); // Jangan lebih dari total
        }
    }
}