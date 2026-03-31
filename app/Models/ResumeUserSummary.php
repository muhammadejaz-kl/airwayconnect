<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeUserSummary extends Model
{
    protected $fillable = [
        'user_id',
        'summary',
    ];
}
