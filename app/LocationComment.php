<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class LocationComment extends Model
{
    protected $fillable = [
        'user_id','location_id','reply_id','reply_user_id','comment'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    public function me()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function him()
    {
        return $this->belongsTo(User::class,'reply_user_id');
    }


}
