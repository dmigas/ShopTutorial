<?php

namespace Database\Seeders;

use App\Models\ProductImage;
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
        $products = \App\Models\Product::factory()
            ->has(ProductImage::factory()->count(1))
            ->count(10)
            ->create();
        $categories = \App\Models\Category::factory()->count(10)->create();

        $products->each(function($product) use ($categories){
            $product->categories()->attach(
                $categories->random(rand(1,2))
            );
        });
    }
}
