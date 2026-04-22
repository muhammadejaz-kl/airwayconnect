<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'code',
        'discount',
        'description',
        'status'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'coupon_id');
    }
}
