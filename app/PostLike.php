<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $fillable = [
        'user_id','post_id','is_like'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
