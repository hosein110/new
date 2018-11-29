<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Analyze extends Model
{
protected $fillable=['from_url','this_url','ip','os','browser','created_at','domain','keyword'];

    public function scopeSearch($query, $keyword,$date)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("this_url", "LIKE","%$keyword%")  ;

            });
        }

        if ($date!='') {

            $date = Carbon::now()->subDays($date);
            $query->where(function ($query) use ($date) {
                $query->where("created_at", ">=",$date)  ;

            });
        }
        return $query;
    }

    public function scopeSearchKeyword($query, $keyword,$date)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("keyword", "LIKE","%$keyword%")  ;

            });
        }

        if ($date!='') {

            $date = Carbon::now()->subDays($date);
            $query->where(function ($query) use ($date) {
                $query->where("created_at", ">=",$date)  ;

            });
        }
        return $query;
    }


}
