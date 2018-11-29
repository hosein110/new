<?php


use App\PostImage;
use Faker\Generator as Faker;


$factory->define(PostImage::class, function (Faker $faker) {
    static   $x=4001;
    return [

        'post_id' =>$x++,
        'image_path' => $faker->imageUrl(),

        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];
});