<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReplyLikes extends Model
{
    protected $fillable = [
        'user_id',
        'forum_id',
        'comment_id',
        'reply_id',
    ];
}
