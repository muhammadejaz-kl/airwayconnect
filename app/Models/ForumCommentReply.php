<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumCommentReply extends Model
{
    protected $fillable = [
        'user_id',
        'forum_id',
        'comment_id',
        'reply',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(ForumCommentLike::class, 'comment_id', 'id');
    }
    public function comment()
    {
        return $this->belongsTo(ForumComment::class, 'comment_id');
    }

    public function Replylikes()
    {
        return $this->hasMany(ForumReplyLikes::class, 'reply_id');
    }
}
