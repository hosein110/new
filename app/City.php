<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name','state_id','image_path'
    ];
    public function state()
    {
        return $this->belongsTo(State::class);
    }




}
