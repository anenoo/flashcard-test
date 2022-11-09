<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\FlashcardCreate;
use App\Models\Flashcards;
use App\Services\FlashcardsService;
use Tests\TestCase;

class FlashcardsCreateTest extends TestCase
{
    /**
     * @cover FlashcardsCreate::handle
     * @cover FlashcardsCreate::AskForInputs
     * @cover FlashcardsCreate::saveFlashCard
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_be_able_to_create_new_flashcards(): void
    {
        $this->artisan('flashcard:create')
            ->expectsQuestion(FlashcardCreate::ASK_FOR_QUESTION, fake()->sentence(5))
            ->expectsQuestion(FlashcardCreate::ASK_FOR_HINT, fake()->sentence(5))
            ->expectsQuestion(FlashcardCreate::ASK_FOR_ANSWER, fake()->word())
            ->expectsOutput('Flashcard created successfully')
            ->assertExitCode(0);
    }

    /**
     * @cover FlashcardsCreate::handle
     * @cover FlashcardsCreate::isValidationPassed
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_not_be_able_to_create_duplicate_questions(): void
    {
        $fistFlashCard = Flashcards::first();
        $this->artisan('flashcard:create')
            ->expectsQuestion(FlashcardCreate::ASK_FOR_QUESTION, $fistFlashCard->question)
            ->expectsQuestion(FlashcardCreate::ASK_FOR_HINT, $fistFlashCard->hint)
            ->expectsQuestion(FlashcardCreate::ASK_FOR_ANSWER, $fistFlashCard->answer)
            ->expectsOutput('The question has already been taken.')
            ->assertExitCode(0);
    }

    /**
     * @cover FlashcardsCreate::handle
     * @cover FlashcardsCreate::isValidationPassed
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_not_be_able_to_create_question_without_answer(): void
    {
        $this->artisan('flashcard:create')
            ->expectsQuestion(FlashcardCreate::ASK_FOR_QUESTION, fake()->sentence(5))
            ->expectsQuestion(FlashcardCreate::ASK_FOR_HINT, fake()->sentence(5))
            ->expectsQuestion(FlashcardCreate::ASK_FOR_ANSWER, '')
            ->expectsOutput('The answer field is required.')
            ->assertExitCode(0);
    }

    /**
     * @cover FlashcardsCreate::handle
     * @cover FlashcardsCreate::isValidationPassed
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_not_be_able_to_create_flashcard_without_question(): void
    {
        $this->artisan('flashcard:create')
            ->expectsQuestion(FlashcardCreate::ASK_FOR_QUESTION, '')
            ->expectsQuestion(FlashcardCreate::ASK_FOR_HINT, fake()->sentence(5))
            ->expectsQuestion(FlashcardCreate::ASK_FOR_ANSWER, fake()->word())
            ->expectsOutput('The question field is required.')
            ->assertExitCode(0);
    }

    /**
     * @cover FlashcardsCreate::handle
     * @cover FlashcardsCreate::isValidationPassed
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_be_able_to_create_flashcard_without_hind(): void
    {
        $this->artisan('flashcard:create')
            ->expectsQuestion(FlashcardCreate::ASK_FOR_QUESTION, fake()->sentence(5))
            ->expectsQuestion(FlashcardCreate::ASK_FOR_HINT, '')
            ->expectsQuestion(FlashcardCreate::ASK_FOR_ANSWER, fake()->word())
            ->expectsOutput('Flashcard created successfully')
            ->assertExitCode(0);
    }
}
