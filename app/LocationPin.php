<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationPin extends Model
{
    protected $fillable = [
        'location_id','user_id','is_pin'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
