<?php

namespace App\Console\Commands;

use App\Models\Flashcards;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FlashcardCreate extends Command
{
    public const ASK_FOR_QUESTION = 'Give the question';
    public const ASK_FOR_HINT = 'Add a hint, if it needs';
    public const ASK_FOR_ANSWER = 'What is the correct answer';
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
        $question = $this->ask(self::ASK_FOR_QUESTION);
        $bar->advance();
        $this->line('');

        $hint = $this->ask(self::ASK_FOR_HINT);
        $bar->advance();
        $this->line('');

        $answer = $this->ask(self::ASK_FOR_ANSWER);
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
        if ($this->isValidationPassed($question, $hint, $answer)) {
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

    /**
     * @param mixed $question
     * @param mixed $hint
     * @param mixed $answer
     * @return false
     */
    public function isValidationPassed(mixed $question, mixed $hint, mixed $answer): bool
    {
        $validator = Validator::make(
            [
                'question' => $question,
                'hint' => $hint,
                'answer' => $answer
            ],
            [
                'question' => 'required|unique:flashcards|max:255',
                'answer' => 'required'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }
            return false;
        }

        return true;
    }
}
