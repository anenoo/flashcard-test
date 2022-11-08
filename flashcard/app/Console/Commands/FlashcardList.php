<?php

namespace App\Console\Commands;

use App\Services\FlashcardsService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;

class FlashcardList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A table listing all the created flashcard questions with the correct answer.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FlashcardsService $flashcardsService)
    {
        $list = $flashcardsService->getFlashcardsWithAnswerAndStats();
        $getCompletion = $flashcardsService->getCompletion($flashcardsService, $list);
        $this->createANewTableInstanceWithCompletionFooterWithAnswer($list, $getCompletion);

        return Command::SUCCESS;
    }


    /**
     * @param array $list
     * @param float $getCompletion
     * @return void
     */
    public function createANewTableInstanceWithCompletionFooterWithAnswer(array $list, float $getCompletion): void
    {
        // Create a new Table instance.
        $table = new Table($this->output);

        // Set the table headers.
        $table->setHeaders([
            ['ID', 'Question', 'Correct Answer', 'State']
        ]);

        // Create a new TableSeparator instance.
        $separator = new TableSeparator();

        // Set the contents of the table.
        $table->setRows([
            ...$list,
            $separator,
            [
                new TableCell('Completion', ['colspan' => 2]),
                new TableCell($getCompletion . '%', ['colspan' => 2])
            ],
        ]);

        // Render the table to the output.
        $table->render();
    }
}
