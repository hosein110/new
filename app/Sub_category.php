<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_category extends Model
{
   protected $fillable=['title','image_path','category_id'];

    public function categories()
    {
    return $this->belongsTo(Category::class);
   }
}
