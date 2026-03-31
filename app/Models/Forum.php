<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = [
        'user_id',
        'topic_ids',
        'name',
        'description',
        'banner',
        'status',
        'restricted_ids',
    ];
    protected $casts = [
        'topic_ids' => 'array',
        'restricted_ids' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(ForumLike::class);
    }
    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }
    public function comment_likes()
    {
        return $this->hasMany(ForumComment::class);
    }
}
