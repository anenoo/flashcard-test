<?php

namespace App\Console\Commands;

use App\Models\Flashcards;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class FlashcardCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The user will be prompted to give a flashcard question and the only answer to that question.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bar = $this->output->createProgressBar(3);
        $bar->start();

        list($question, $hint, $answer) = $this->AskForInputs($bar);

        $bar->finish();

        $this->saveFlashCard($question, $hint, $answer);

        return Command::SUCCESS;
    }

    /**
     * @param $bar
     * @return array
     */
    public function AskForInputs($bar): array
    {
        $question = $this->ask('Give the question');
        $bar->advance();
        $this->line('');

        $hint = $this->ask('Add a hint, if it needs');
        $bar->advance();
        $this->line('');

        $answer = $this->ask('What is the correct answer');
        $bar->advance();
        $this->line('');
        return array($question, $hint, $answer);
    }

    /**
     * @param mixed $question
     * @param mixed $hint
     * @param mixed $answer
     * @return void
     */
    public function saveFlashCard(mixed $question, mixed $hint, mixed $answer): void
    {
        $newFlashCard = Flashcards::create([
            'question' => $question,
            'hint' => $hint,
            'answer' => $answer,
        ]);
        if ($newFlashCard->id) {
            $this->info('Flashcard created successfully');
        } else {
            $this->error('Something went wrong, please check again.');
        }
    }
}
