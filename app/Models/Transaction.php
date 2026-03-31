<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "transaction_id",
        "user_id",
        "username",
        "plan_id",
        "validity",
        "coupon_id",
        "code",
        "coupon_discount",
        "total_amount",
        "paid_amount",
        "payment_status",
        "response"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Subscription::class, 'plan_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

}
