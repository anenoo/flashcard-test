<?php

namespace Tests\Unit\Console\Commands;

use Tests\TestCase;

class FlashcardsResetTest extends TestCase
{
    /**
     * @cover FlashcardsReset::handle
     * @group FlashcardsReset
     * @test
     * @return void
     */
    public function we_should_be_able_to_reset_data_by_question(): void
    {
        $this->artisan('flashcard:reset')
            ->expectsConfirmation('Are you sure about reset all information?', true)
            ->assertExitCode(0);
    }
}
