<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Fill;

class JobPost extends Model
{
    protected $fillable= [
        'title',
        'for_airlines',
        'type',
        'description',
        'last_date',
        'location',
        'experience',
        'status',
        'link',
    ];
}
