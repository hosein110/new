<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'title','image_path','status'
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
