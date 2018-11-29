<?php


use App\LocationImage;
use Faker\Generator as Faker;


$factory->define(LocationImage::class, function (Faker $faker) {
  static $x=1;
  return [

        'location_id' =>$x++,
        'image_path' => $faker->imageUrl(),

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});