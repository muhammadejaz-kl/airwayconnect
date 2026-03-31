<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirlineDirectory extends Model
{

    protected $fillable = [
        'name',
        'logo'
    ];

    public function details()
    {
        return $this->hasMany(AirlineDetail::class, 'airline_id');
    }
}
