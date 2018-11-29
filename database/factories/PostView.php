<?php


use App\LocationImage;
use Faker\Generator as Faker;


$factory->define(\App\PostView::class, function (Faker $faker) {
    return [

        'post_id' =>rand(1,1000),
        'user_id' =>rand(1,200),
        'ip' =>$faker->ipv4(),
        'mac' =>$faker->macAddress(),

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});