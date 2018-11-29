<?php

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,200),
        'category_id' =>rand(1,5),
        'content' => $faker->unique()->text(200),
        'price' => $faker->numberBetween(10000,100000),
        'tel' => $faker->phoneNumber,
        'date_time' => $faker->dateTime,
        'name'=> $faker->name(),
        'state_id' =>$faker->numberBetween(1,17),
        'city_id' => $faker->numberBetween(1,2),
        'lat' => $faker->latitude,
        'longitude' => $faker->longitude,
        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});
