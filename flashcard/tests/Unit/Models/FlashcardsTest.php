<?php

namespace Tests\Unit\Models;

use App\Models\Constants\FlashcardsStates;
use App\Models\Flashcards;
use App\Models\User;
use App\Models\UsersAnswers;
use Artisan;
use Tests\TestCase;

class FlashcardsTest extends TestCase
{
    /**
     * @cover Flashcards::usersAnswers
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_users_answers(): void
    {
        $flashcard = Flashcards::first();
        $usersAnswers = $flashcard->usersAnswers();
        $this->assertTrue((count($usersAnswers->get()->toArray())) >= 0);
    }

    /**
     * @cover Flashcards::getAnswersAsArray
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_users_answers_as_array(): void
    {
        $flashcard = Flashcards::first();
        $usersAnswersAsArray = $flashcard->getAnswersAsArray();
        $this->assertTrue((count($usersAnswersAsArray)) >= 0);
        $this->assertTrue(is_array($usersAnswersAsArray));
    }

    /**
     * @cover Flashcards::getState
     * @group FlashcardsCreate
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_styled_state_of_question(): void
    {
        $flashcard = Flashcards::first();
        $state = $flashcard->getStylesState();
        $this->assertTrue(in_array($state, [
            FlashcardsStates::STATE_STYLED_CORRECT,
            FlashcardsStates::STATE_STYLED_INCORRECT,
            FlashcardsStates::STATE_STYLED_NOT_ANSWERED
        ]));
    }

    /**
     * @cover Flashcards::getStateByUser
     * @group Flashcards
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_state_for_a_user_about_question(): void
    {
        $flashcard = Flashcards::first();
        $user = User::first();
        UsersAnswers::Create([
            'answer' => $flashcard->answer,
            'user_id' => $user->id,
            'flashcards_id' => $flashcard->id
        ]);
        $state = $flashcard->getStateByUser($user);
        $this->assertTrue(($state === FlashcardsStates::STATE_CORRECT));
    }
}
