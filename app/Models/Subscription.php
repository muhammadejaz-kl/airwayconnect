<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'name',
        'validity',
        'amount',
        'features',
        'status'
    ] ;
}
