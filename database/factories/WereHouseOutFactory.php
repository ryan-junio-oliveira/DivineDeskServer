<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WereHouseOut>
 */
class WereHouseOutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'were_house_id' => \App\Models\WereHouse::factory(),
            'quantity' => $this->faker->randomDigit(0),
            'date' => $this->faker->date('Y-m-d', 'now'),
        ];
    }
}
