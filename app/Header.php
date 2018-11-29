<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'created_at', 'status', 'updated_at'];

    public function messages()
    {
        return $this->hasOne(UserChat::class);
    }

    public function unread_count()
    {
        return $this->hasMany(UserChat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getCreatedAtAttribute($value)
    {
        if ($value != '')
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
        else
            return $value;
    }
}
