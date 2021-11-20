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
        return [
            'name' => $this->faker->sentence(2),
            'code' => 'A-' . $this->faker->randomNumber(8),
            'barcode' => $this->faker->ean13(),
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomNumber(2),
        ];
    }
}
