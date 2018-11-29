<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostRate extends Model
{
    protected $fillable = [
        'rate','user_id','post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
