<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $hidden=['created_at','updated_at','location_id','id'];
    protected $fillable = [
        'location_id',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
