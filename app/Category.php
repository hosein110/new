<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title','image_path','type','status'
    ];

    public function locations()
    {
        return $this->hasMany(Location::class,'category_id','id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class,'category_id','id');
    }

    public function sub_category()
    {
        return $this->hasMany(Sub_category::class);
    }
}
