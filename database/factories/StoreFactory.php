<?php

use App\Models\Community;
use App\Models\Store;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Store::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'address' => $faker->address,
        'image' => 'https://picsum.photos/seed/'. $faker->word .'/300/300',
        'phone' => '62'. $faker->randomNumber(10),
        'verified_at' => $faker->randomElement([null, now()]),
        'community_id' => function () {
            return Community::inRandomOrder()->first()->id;
        },
    ];
});
