<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserResume extends Model
{
    protected $fillable = [
        'user_id',
        'resume',
        'template_id',
    ];
}
