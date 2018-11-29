<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $hidden = [
        'id','user_id','post_id','created_at','updated_at'
    ];
    protected $fillable = [
        'image_path','resize_path','watermark_path','user_id','post_id','sort'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }


}
