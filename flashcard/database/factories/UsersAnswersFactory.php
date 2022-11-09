<?php

namespace Database\Factories;

use App\Models\UsersAnswers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UsersAnswers>
 */
class UsersAnswersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'answer' => fake()->word(),
            'user_id' => 1,
            'flashcards_id' => rand(1, 8)
        ];
    }
}
