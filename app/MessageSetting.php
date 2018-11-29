<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageSetting extends Model
{
    protected $fillable = [
        'user_id','receive_news','remember_email','product_email','research_email'
    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
