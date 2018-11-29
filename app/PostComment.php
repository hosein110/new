<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = [
        'comment','user_id','post_id','reply_id','reply_user_id'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function me()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function him()
    {
        return $this->belongsTo(User::class,'reply_user_id');
    }



}
