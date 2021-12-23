<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $category = Category::factory()->create();
        Product::factory(10000)
            ->for($category)
            ->has(ProductVariant::factory()->count(2))
            ->create();

        /*Category::factory(20)
            ->has(Product::factory()->count(5)
                ->has(ProductVariant::factory()->count(2))
            )->create();*/
    }
}
