<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    protected $fillable = [
        'user_id',
        'forum_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(ForumCommentLike::class, 'comment_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(\App\Models\ForumCommentReply::class, 'comment_id');
    }
}
