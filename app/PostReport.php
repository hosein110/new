<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReport extends Model
{
    protected $fillable = [
        'user_id','post_id','report_type_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function report_type()
    {
        return $this->belongsTo(ReportType::class);
    }

}
