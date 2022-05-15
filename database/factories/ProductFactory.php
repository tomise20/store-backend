<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $price = $this->faker->numberBetween(5000, 15000);
        $salePrice = $this->faker->boolean() ? $this->faker->numberBetween(3000, $price - 1) : null;
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraphs($this->faker->numberBetween(1, 3), true),
            'price' => $price,
            'sale_price' => $salePrice,
            'stock' => $this->faker->numberBetween(0, 100),
            'available' => $this->faker->boolean(),
            'image' => 'https://cdn.pixabay.com/photo/2021/09/17/12/12/coffee-6632524_960_720.jpg'
        ];
    }
}
