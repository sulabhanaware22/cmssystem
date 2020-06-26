<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'url' => $faker->imageUrl('900','300')
    ];
});
