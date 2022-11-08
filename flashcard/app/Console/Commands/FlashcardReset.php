<?php

namespace App\Console\Commands;

use App\Models\Constants\FlashcardsResetActions;
use Illuminate\Console\Command;

class FlashcardReset extends Command
{
    public const DEFAULT_ACTION_INDEX = 0;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command should erase all practice progress and allow a fresh start.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Are you sure about reset all information?', true)) {
            $this->line('Cleaning all flash cards...');
            \Artisan::call(
                'migrate:fresh',
                array('--seed' => true)
            );
            $this->info('Everything happily reset :)');
        }

        return Command::SUCCESS;
    }
}
