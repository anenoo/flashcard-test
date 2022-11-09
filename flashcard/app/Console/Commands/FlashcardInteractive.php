<?php

namespace App\Console\Commands;

use App\Models\Constants\FlashcardsInteractiveActions;
use Illuminate\Console\Command;

class FlashcardInteractive extends Command
{
    public const DEFAULT_ACTION_INDEX = 0;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive
    {--action: You can select one of these actions Create/List/Practice/Stats/Reset/Exit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is an interactive CLI program for Flashcard practice.
    For context: a flashcard is a spaced repetition tool for memorising questions
    and their respective answers.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->checkTheInitialAction()) {
            return;
        }

        return Command::SUCCESS;
    }

    /**
     * @return false
     */
    public function checkTheInitialAction(): bool
    {
        $takeAction = $this->choice(
            'What are you looking for?',
            [
                FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_LIST,
                FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_CREATE,
                FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_PRACTICE,
                FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_STATS,
                FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_RESET,
                FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_EXIT
            ],
            $this::DEFAULT_ACTION_INDEX,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );

        switch ($takeAction) {
            case FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_CREATE:
                $this->call('flashcard:create');
                break;
            case FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_LIST:
                $this->call('flashcard:list');
                break;
            case FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_PRACTICE:
                $this->call('flashcard:practice');
                break;
            case FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_STATS:
                $this->call('flashcard:stats');
                break;
            case FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_RESET:
                $this->call('flashcard:reset');
                break;
            case FlashcardsInteractiveActions::FLASHCARD_INTERACTIVE_ACTION_EXIT:
                return false;
            default:
                $this->call('flashcard:list');
        }
        return true;
    }
}
