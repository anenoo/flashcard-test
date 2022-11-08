<?php

namespace Database\Factories;

use App\Models\Flashcards;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UsersAnswers>
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
