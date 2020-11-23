<?php

use App\Models\User;
use App\Models\UserAddress;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(UserAddress::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'city' => $faker->city,
        'province' => $faker->word,
        'zipcode' => $faker->postcode,
        'phone' => $faker->phoneNumber,
        'created_at' => $faker->word,
        'updated_at' => $faker->word,

        'user_id' => function () {
            return User::inRandomrder()->first()->id;
        },
    ];
});
