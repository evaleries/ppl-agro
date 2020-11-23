<?php

use App\Models\Product;
use App\Models\Store;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'price' => $faker->randomElement([30000, 50000, 750000, 100000, 1500000]),
        'stock' => $faker->randomNumber(),
        'description' => $faker->text,
        'extra_info' => json_encode([
            'weight' => 1,
            'weight_name' => 'kg',
        ]),

        'store_id' => function () {
            return Store::inRandomOrder()->first()->id;
        },
    ];
});
