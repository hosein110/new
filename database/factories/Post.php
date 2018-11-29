<?php


use App\Post;
use Faker\Generator as Faker;


$factory->define(Post::class, function (Faker $faker) {
    static $x=2;
    return [
        'user_id' => rand(1,200),
        'category_id' =>rand(5,10),
        'location_id' =>$x++,

        'caption'=> $faker->name(),

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});