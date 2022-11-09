<?php

namespace Tests\Unit\Console\Commands;

use App\Services\FlashcardsService;
use Artisan;
use Tests\TestCase;

class FlashcardsStatsTest extends TestCase
{
    /**
     * @cover FlashcardsStats::handle
     * @group FlashcardsStats
     * @test
     * @return void
     */
    public function we_should_be_able_to_see_the_stats(): void
    {
        $flashcardService = new FlashcardsService();
        $getStats = $flashcardService->calculateStats();
        $this->artisan('flashcard:stats')
            ->expectsOutput('- The total amount of questions is ' . $getStats->getTotal() . '.')
            ->expectsOutput('- ' . $getStats->calculateAnsweredPercent() . '% of questions that have an answer.')
            ->expectsOutput('- ' . $getStats->calculateCorrectAnsweredPercent() . '% of questions that have a correct answer.')
            ->assertExitCode(0);
    }
}
