<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $hidden = [
      'user_id','category_id'
    ];
    protected $fillable = [
        'user_id','category_id','sub_category_id','location_id','ptotal','caption','slug'

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }



    public function tag()
    {
        return $this->belongsToMany(Sub_category::class);
    }





    public function comments()
    {
        return $this->hasMany(PostComment::class,'post_id','id');
    }

    public function comment()
    {
        return $this->hasOne(PostComment::class,'post_id','id');
    }


    public function images()
    {
        return $this->hasMany(PostImage::class,'post_id','id');
    }

    public function image()
    {
        return $this->hasOne(PostImage::class,'post_id','id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class,'post_id','id');
    }



    public function prices()
    {
        return $this->hasMany(PostPrice::class,'post_id','id');
    }



    public function rates()
    {
        return $this->hasMany(PostRate::class,'post_id','id');
    }



    public function reports()
    {
        return $this->hasMany(PostReport::class,'post_id','id');
    }



    public function stares()
    {
        return $this->hasMany(PostStar::class,'post_id','id');
    }
    public function wish_list()
    {
        return $this->hasMany(LocationPin::class,'location_id','location_id');
    }


    public function views()
    {
        return $this->hasMany(PostView::class,'post_id','id');
    }
}
