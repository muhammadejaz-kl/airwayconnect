<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewTopic extends Model
{
    protected $fillable = [
        'topic',
        'description',
        'status'
    ];

    public function questions()
    {
        return $this->hasMany(InterviewQuestionAnswer::class, 'topic_id');
    }
}
