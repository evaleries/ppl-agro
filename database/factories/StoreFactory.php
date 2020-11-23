<?php

use App\Models\Store;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Store::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'address' => $faker->address,
        'description' => $faker->text,
        'image' => $faker->imageUrl(),
        'verified_at' => $faker->randomElement([null, now()]),
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
    ];
});
