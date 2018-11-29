<?php


use App\LocationImage;
use Faker\Generator as Faker;


$factory->define(\App\LocationLike::class, function (Faker $faker) {
    return [

        'location_id' =>rand(1,1000),
        'user_id' =>rand(1,200),
        'is_like' =>1,

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});