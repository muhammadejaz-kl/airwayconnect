<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeContactDetail extends Model
{
    protected $fillable = [
        'user_id',
        'experience_level',
        'first_name',
        'surname',
        'phone',
        'email',
        'date_of_birth',
        'nationality',
        'residential_address',
        'license_no',
        'hobbies',
        'language',
        'marital_status',
        'active_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
