<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeUserSkill extends Model
{
    protected $fillable = [
        'user_id',
        'skill',
    ];
}
