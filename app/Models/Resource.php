<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        // 'category_id',
        'title',
        'description',
        'banner',
        'about'
    ];
}
