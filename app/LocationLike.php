<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationLike extends Model
{
    protected $fillable = [
        'location_id','user_id','is_like'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
