<?php


use App\LocationImage;
use Faker\Generator as Faker;


$factory->define(\App\LocationRate::class, function (Faker $faker) {
    return [

        'location_id' =>rand(1,1000),

        'user_id' =>rand(1,200),
        'rate' =>rand(1,5),

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});