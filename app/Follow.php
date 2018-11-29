<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'user_id','follower_id','accept'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
