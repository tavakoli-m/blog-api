<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['body', 'user_id', 'post_id','comment_id','status'])]
class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class,'post_id');
    }

    public function parrent() : BelongsTo
    {
        return $this->belongsTo(Comment::class,'comment_id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(Comment::class,'comment_id');
    }
}
