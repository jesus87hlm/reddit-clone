<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'url' => $faker->url,
        'user_id' => function(){
            return factory(App\User::class)->create()->id;
        }
    ];
});