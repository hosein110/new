<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id','version_app','content','department'
    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {

        return  Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }

}
