<?php


use App\LocationImage;
use Faker\Generator as Faker;


$factory->define(\App\PostStar::class, function (Faker $faker) {
    return [

        'post_id' =>rand(1,1000),
        'user_id' =>rand(1,200),
        'is_star' =>rand(0,1),

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});