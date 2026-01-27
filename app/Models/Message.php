<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id')->latest();
    }

    public function getContentFormattedAttribute()
    {
        return preg_replace(
            '/@([a-zA-Z0-9_]+)/',
            '<a href="/@$1" class="text-blue-500 hover:underline font-bold">@$1</a>',
            e($this->content)
        );
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
