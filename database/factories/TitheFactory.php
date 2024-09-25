<?php

namespace Database\Factories;
use App\Models\Tithe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tithe>
 */
class TitheFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tithe::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Auth::id(),
            'member_id' =>  \App\Models\Member::factory(),
            'value' => $this->faker->randomFloat(1, 20, 30),
            'date' => $this->faker->date(),
        ];
    }
}
