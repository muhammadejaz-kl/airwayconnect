<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewQuestionAnswer extends Model
{
    protected $fillable = [
        'topic_id',
        'type',
        'question',
        'options',
        'answer',
        'status',
    ];

    public function topic()
    {
        return $this->belongsTo(InterviewTopic::class, 'topic_id');
    }
}
