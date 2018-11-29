<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationReport extends Model
{
    protected $fillable = [
        'location_id','user_id','report_type_id'
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function report_type()
    {
        return $this->belongsTo(ReportType::class);
    }
}
