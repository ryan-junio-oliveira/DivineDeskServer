<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhereHouse>
 */
class WereHouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

            return [

                'name' => $this->faker->name,
                'quantity' => $this->faker->randomDigit(0),
                'date' => $this->faker->date('Y-m-d', 'now'),
            ];

    }
}
