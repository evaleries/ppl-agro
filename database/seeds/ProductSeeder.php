<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductRating;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::insert([
            ['name' => 'Latte'],
            ['name' => 'Cappuccino'],
            ['name' => 'Arabica'],
            ['name' => 'Robusta'],
            ['name' => 'Americano'],
            ['name' => 'Espresso'],
            ['name' => 'Black'],
            ['name' => 'Doppio'],
            ['name' => 'Cortado'],
            ['name' => 'Red Eye'],
            ['name' => 'Mocha'],
            ['name' => 'Ristretto'],
            ['name' => 'Flat White'],
            ['name' => 'Affogato'],
            ['name' => 'Irish'],
        ]);
        factory(Product::class, 30)->create();
        factory(ProductImage::class, 60)->create();
        factory(ProductRating::class, 90)->create();
    }
}
