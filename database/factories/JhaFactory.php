<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jha>
 */
class JhaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => rtrim(fake()->text(30), '.'),
            'author' => fake()->firstName().' '.fake()->lastName(),
            'description' => fake()->sentence(3)
        ];
    }
}
