<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostStar extends Model
{
    protected $fillable = [
        'user_id','post_id','is_star'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
