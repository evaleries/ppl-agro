<?php

use App\Models\Order;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Order::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement(['Pending', 'Shipped', 'Completed', 'Cancelled']),
        'description' => $faker->realText(),
        'paid_at' => $faker->randomElement([null, now()->toDateTimeString()]),

        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
