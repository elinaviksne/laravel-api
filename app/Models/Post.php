<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id', 'status_id'];

    public function getIsPrivateAttribute()
    {
        return $this->status->name === PostStatus::STATUS_PRIVATE;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function status()
    {
        return $this->belongsTo(PostStatus::class);
    }
}
