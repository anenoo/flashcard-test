<?php

namespace Tests\Unit\Services;

use App\Services\FlashcardsService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class FlashcardsServiceTest extends TestCase
{
    /**
     * @cover FlashcardsService::getTotalFlashCardsCount
     * @group FlashcardService
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_total_question_count(): void
    {
        $flashcardsService = new FlashcardsService();
        $total = $flashcardsService->getTotalFlashCardsCount();
        $this->assertTrue(($total === 10));
    }

    /**
     * @cover FlashcardsService::getTotalAnsweredQuestion
     * @group FlashcardService
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_total_answered_question_count(): void
    {
        $flashcardsService = new FlashcardsService();
        $total = $flashcardsService->getTotalAnsweredQuestion();
        $this->assertTrue(($total >= 0));
    }

    /**
     * @cover FlashcardsService::getCorrectAnswerQuestions
     * @group FlashcardService
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_total_correct_answered_question_count(): void
    {
        $flashcardsService = new FlashcardsService();
        $total = $flashcardsService->getCorrectAnswerQuestions();
        $this->assertTrue(($total >= 0));
    }


    /**
     * @cover FlashcardsService::calculateStats
     * @cover StateResult::calculateCorrectAnsweredPercent
     * @group FlashcardService
     * @group StateResult
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_percent_of_correct_answered_question(): void
    {
        $flashcardsService = new FlashcardsService();
        $getStats = $flashcardsService->calculateStats();
        $this->assertTrue(($getStats->calculateCorrectAnsweredPercent() >= 0));
    }

    /**
     * @cover FlashcardsService::calculateStats
     * @cover StateResult::calculateCorrectAnsweredPercent
     * @group FlashcardService
     * @group StateResult
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_percent_of_answered_question(): void
    {
        $flashcardsService = new FlashcardsService();
        $getStats = $flashcardsService->calculateStats();
        $this->assertTrue(($getStats->calculateAnsweredPercent() >= 0));
    }

    /**
     * @cover FlashcardsService::getFlashcardsWithAnswerAndStats
     * @group FlashcardService
     * @group StateResult
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_flashcards_with_answer_and_state(): void
    {
        $flashcardsService = new FlashcardsService();
        $flashcardsList = $flashcardsService->getFlashcardsWithAnswerAndStats();
        $OneFlashCard = $flashcardsList[0];
        $id = $OneFlashCard[0];
        $this->assertTrue(count($flashcardsList) >= 0);
        $this->assertTrue(($id > 0));
        $this->assertTrue((count($OneFlashCard) == 4));
    }

    /**
     * @cover FlashcardsService::getFlashcardsWithStatsAndHint
     * @group FlashcardService
     * @group StateResult
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_flashcards_with_hint_and_state(): void
    {
        $flashcardsService = new FlashcardsService();
        $flashcardsList = $flashcardsService->getFlashcardsWithAnswerAndStats();
        $OneFlashCard = $flashcardsList[0];
        $id = $OneFlashCard[0];
        $this->assertTrue(count($flashcardsList) >= 0);
        $this->assertTrue(($id > 0));
        $this->assertTrue((count($OneFlashCard) == 4));
    }

    /**
     * @cover FlashcardsService::getCompletion
     * @group FlashcardService
     * @group StateResult
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_completion_of_the_cards(): void
    {
        $flashcardsService = new FlashcardsService();
        $flashcardsList = $flashcardsService->getFlashcardsWithAnswerAndStats();
        $getCompletion = $flashcardsService->getCompletion($flashcardsList);
        $this->assertTrue($getCompletion >= 0);
    }
}
