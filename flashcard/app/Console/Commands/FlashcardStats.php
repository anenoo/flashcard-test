<?php

namespace App\Console\Commands;

use App\Services\FlashcardsService;
use Illuminate\Console\Command;

class FlashcardStats extends Command
{
    public const TOTAL_MESSAGE_START = '<fg=bright-magenta>- The total amount of questions is ';
    public const TOTAL_MESSAGE_END = '.</>';
    public const ANSWERED_MESSAGE_START = '<fg=bright-blue>- ';
    public const ANSWERED_MESSAGE_END = '% of questions that have an answer.</>';
    public const CORRECT_MESSAGE_START = '<fg=bright-green>- ';
    public const CORRECT_MESSAGE_END = '% of questions that have a correct answer.</>';
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
        $this->info(self::TOTAL_MESSAGE_START . $stateResult->getTotal() . self::TOTAL_MESSAGE_END);
        $this->info(self::ANSWERED_MESSAGE_START . $stateResult->calculateAnsweredPercent() . self::ANSWERED_MESSAGE_END);
        $this->info(self::CORRECT_MESSAGE_START . $stateResult->calculateCorrectAnsweredPercent() . self::CORRECT_MESSAGE_END);
        return Command::SUCCESS;
    }
}
