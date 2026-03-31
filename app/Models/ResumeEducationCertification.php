<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeEducationCertification extends Model
{
    protected $fillable = [
        'user_id',
        'count',
        'best_match',
        'school_name',
        'school_location',
        'degree',
        'field_of_study',
        'graduation_month',
        'graduation_year',
        'certificates',
        'additional_coursework',
    ];
    
}
