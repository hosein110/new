<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostPrice extends Model
{
    protected $fillable = [
        'field','price','post_id','description','image_path'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
