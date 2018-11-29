<?php

namespace App;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;



    public function sender()
    {
        return $this->hasMany(UserChat::class,'sender_id','id');
    }

    public function receiver()
    {
        return $this->hasMany(UserChat::class,'receiver_id','id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','fullname','image_path','mobile','bio','register_type','username','last_seen','is_administrator'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token','apiToken'
    ];

    public function UserChatReceivers()
    {
        return $this->hasMany(UserChat::class,'receiver_id','id');
    }

    public function UserChatSenders()
    {
        return $this->hasMany(UserChat::class,'sender_id','id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class,'user_id','id');
    }

    public function followings()
    {
        return $this->hasMany(Follow::class,'user_id','id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class,'user_id','id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class,'user_id','id');
    }

    public function messageSetting()
    {
        return $this->hasOne(MessageSetting::class,'user_id','id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'user_id','id');
    }



    public function getLastSeenAttribute($value)
    {
if($value) {
    return Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
}
    }






    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }



    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        //return !!$role->intersect($this->roles)->count();
        foreach ($role as $r) {
            if ($this->hasRole($r->name)) {
                return true;
            }
        }


    }

    public function assignRole($role)
    {
        $this->roles()->sync(
            Role::whereName($role)->firstOrFail()
        );
    }




    public function getCreatedAtAttribute($value)
    {

        return  Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }





    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("fullname", "LIKE","%$keyword%")
                    ->orWhere("email", "LIKE", "%$keyword%")
                    ->orWhere("username", "LIKE", "%$keyword%")
                    ->orWhere("mobile", "LIKE", "%$keyword%") ;
                ;
            });
        }
        return $query;
    }

}
