<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationInfo extends Model
{
    protected $hidden=['id','location_id','created_at','updated_at'];
    protected $fillable = [
        'title','location_id','description'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
