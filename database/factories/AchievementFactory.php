<?php

namespace Database\Factories;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{

    protected $model = Achievement::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'requirement' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->randomElement(['lesson','comment'])

        ];
    }
}
