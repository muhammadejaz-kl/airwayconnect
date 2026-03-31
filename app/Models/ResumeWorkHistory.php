<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeWorkHistory extends Model
{
    protected $fillable = [
        'user_id',
        'count',
        'job_title',
        'employer',
        'location',
        'remote',
        'start_date',
        'end_date',
        'currently_work',
        'experienced_with',
        'active_status',
    ];
}
