<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationRate extends Model
{
    protected $fillable = [
        'location_id','user_id','rate'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
