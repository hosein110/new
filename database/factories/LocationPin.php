<?php


use App\LocationImage;
use Faker\Generator as Faker;


$factory->define(\App\LocationPin::class, function (Faker $faker) {
    return [

        'location_id' =>rand(1,1000),
        'user_id' =>rand(1,200),
        'is_pin' =>1,

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});