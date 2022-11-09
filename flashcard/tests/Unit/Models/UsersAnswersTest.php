<?php

namespace Tests\Unit\Models;

use App\Models\UsersAnswers;
use Tests\TestCase;

class UsersAnswersTest extends TestCase
{
    /**
     * @cover UsersAnswers::user
     * @group UserAnswer
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_user(): void
    {
        $userAnswer = UsersAnswers::first();
        $user = $userAnswer->user()->get()->toArray();
        $this->assertTrue((count($user) === 1));
        // number of fields in user is 6
        $this->assertTrue((count($user[0]) === 6));
    }

    /**
     * @cover UsersAnswers::flashcards
     * @group UserAnswer
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_flashcard(): void
    {
        $userAnswer = UsersAnswers::first();
        $flashcard = $userAnswer->flashcards()->get()->toArray();
        $this->assertTrue((count($flashcard) === 1));
        // number of fields in user is 6
        $this->assertTrue((count($flashcard[0]) === 6));
    }
}
