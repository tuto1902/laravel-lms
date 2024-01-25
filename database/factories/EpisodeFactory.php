<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'length_in_minutes' => fake()->randomDigit(),
            'sort' => fake()->randomDigit(),
            'vimeo_id' => fake()->text(9),
            'overview' => fake()->sentence(50)
        ];
    }
}
