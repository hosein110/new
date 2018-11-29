<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationImage extends Model
{
    protected $hidden=['location_id','id','created_at'];
    protected $fillable = [
        'image_path','resize_path','watermark_path','location_id','sort'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
