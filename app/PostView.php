<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    protected $fillable = [
        'user_id','post_id','ip','mac'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
