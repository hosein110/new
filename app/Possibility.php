<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Possibility extends Model
{
    protected $hidden=['created_at','updated_at','type','status','pivot'];
    protected $fillable = [
        'title','image_path','type','status'
    ];
    public function locations()
    {
        return $this->belongsToMany(Location::class,'location_possibility');
    }
}
