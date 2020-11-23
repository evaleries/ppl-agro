<?php

use App\Models\Product;
use App\Models\ProductImage;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(ProductImage::class, function (Faker $faker) {
    return [
        'path' => 'https://picsum.photos/300/300/?'. $faker->randomNumber(6),
        'product_id' => function () {
            return Product::inRandomOrder()->first()->id;
        },
    ];
});
