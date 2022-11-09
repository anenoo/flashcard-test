<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @cover User::usersAnswers
     * @group User
     * @test
     * @return void
     */
    public function we_should_be_able_to_get_user_answers(): void
    {
        $user = User::first();
        $userAnswers = $user->usersAnswers()->get()->toArray();
        $this->assertTrue((count($userAnswers) >= 10));
    }
}
