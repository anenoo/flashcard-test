<?php

namespace Database\Factories;

use App\Models\Flashcards;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Flashcards>
 */
class FlashcardsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'question' => fake()->sentence(5),
            'answer' => fake()->word(),
            'hint' => fake()->sentence(),
        ];
    }
}
