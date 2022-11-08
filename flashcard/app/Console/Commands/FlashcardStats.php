<?php

namespace App\Console\Commands;

use App\Services\FlashcardsService;
use Illuminate\Console\Command;

class FlashcardStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the following stats: (The total amount of questions.
    / % of questions that have an answer./ % of questions that have a correct answer.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FlashcardsService $flashcardsService)
    {
        $stateResult = $flashcardsService->calculateStats();
        $this->info('<fg=bright-magenta>- The total amount of questions is ' . $stateResult->getTotal().'.</>');
        $this->info('<fg=bright-blue>- ' . $stateResult->calculateAnsweredPercent() . '% of questions that have an answer.</>');
        $this->info('<fg=bright-green>- ' . $stateResult->calculateCorrectAnsweredPercent() . '% of questions that have a correct answer.</>');
        return Command::SUCCESS;
    }
}
