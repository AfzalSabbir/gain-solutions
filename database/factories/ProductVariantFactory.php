<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku'     => $this->faker->text(20),
            'barcode' => $this->faker->text(20),
            'price'   => $this->faker->randomFloat(2, 3, 5),
        ];
    }
}
