<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlashcardExit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:exit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This option will conclude the interactive command.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('Display this on the screen');
        return Command::SUCCESS;
    }
}
