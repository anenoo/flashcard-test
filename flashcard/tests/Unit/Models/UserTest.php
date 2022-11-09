<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Services\FlashcardsService;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @cover User::usersAnswers
     * @group User
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_userAnswers(): void
    {
        $user = User::first();
        $userAnswers = $user->usersAnswers()->get()->toArray();
        $this->assertTrue((count($userAnswers) === 10));
    }
}
