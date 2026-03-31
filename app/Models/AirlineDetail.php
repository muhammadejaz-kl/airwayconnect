<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirlineDetail extends Model
{
    protected $fillable = [
        'airline_id',
        'part',
        'airlines_type',
        'job_type',
        'schedule_type',
        'option_401k',
        'flight_benefits',
        'description',
    ];

    public function airline()
    {
        return $this->belongsTo(AirlineDirectory::class);
    }
}
