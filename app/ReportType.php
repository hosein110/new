<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    protected $fillable = [
        'content','type'
    ];
    public function locationReport()
    {
        return $this->hasOne(LocationReport::class);
    }
    public function postReport()
    {
        return $this->hasOne(PostReport::class);
    }
}
