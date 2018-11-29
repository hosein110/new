<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Location extends Model
{

    protected $fillable = [
     'has_work_time', 'is_confirm','slug',  'user_id', 'category_id', 'content', 'price', 'tel', 'date_time', 'name', 'state_id', 'city_id', 'lat', 'longitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'location_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(LocationComment::class, 'location_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(LocationImage::class, 'location_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(LocationImage::class, 'location_id', 'id');
    }




    public function infos()

    {
        return $this->hasMany(LocationInfo::class, 'location_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(LocationLike::class, 'location_id', 'id');
    }

    public function pins()
    {
        return $this->hasMany(LocationPin::class, 'location_id', 'id');
    }

    public function rates()
    {
        return $this->hasMany(LocationRate::class, 'location_id', 'id');
    }


    public function rate()
    {
        return $this->hasOne(LocationRate::class, 'location_id', 'id');
    }

    public function work_time()
    {
        return $this->hasMany(WorkTime::class, 'location_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany(LocationReport::class, 'location_id', 'id');
    }

    public function possibilities()
    {
        return $this->belongsToMany(Possibility::class,'location_possibility');
    }


    public function transfers()
    {
        return $this->belongsToMany(Possibility::class);
    }

    public function entertainments()
    {
        return $this->belongsToMany(Possibility::class);
    }


    public function scopeOrderByKeyword($query, $orderBY)
    {
        if ($orderBY != 'null') {
            if ($orderBY == 'avg_ptotal')
                $query->orderBy($orderBY, 'ASC');
          else
                $query->orderBy($orderBY, 'DESC');

        }
        return $query;
    }


    public function scopeSearchByState($query,$state_id=0)
    {

        if($state_id>0) {
            return  $query->where('locations.state_id', $state_id);
        }

        return $query;
    }


    public function scopeSearchByCategory($query,$category_id=0)
    {

        if($category_id>0) {
            return  $query->where('locations.category_id', $category_id);
        }

        return $query;
    }



    public function scopeDistance($query, $latitude , $longitude , $distance = 100, $unit = "km")
    {

        if ($latitude != 'null' && $longitude!='null') {
            return $query->where([
                ['lat', '!=', $latitude],
                ['longitude', '!=', $longitude]
            ])->whereRaw(\DB::raw("(3959 * acos( cos( radians($latitude) ) * cos( radians(lat) )  * 
                          cos( radians(longitude) - radians($longitude) ) + sin( radians($latitude) ) * sin( 
                          radians( lat ) ) ) ) < $distance ")
            );

        }

        return $query;
    }



}
