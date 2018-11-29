<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'seen', 'receiver_id', 'sender_id','header_id'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }



    public function UserReceiver()
    {
        return $this->belongsTo(User::class);
    }

    public function UserSender()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        if ($value != '')
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
        else
            return $value;
    }

}
