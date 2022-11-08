<?php

namespace App\Console\Commands;

use App\Models\Constants\FlashcardsStates;
use App\Models\Flashcards;
use App\Models\User;
use App\Models\UsersAnswers;
use App\Services\FlashcardsService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableCell;
use Illuminate\Support\Facades\Auth;

class FlashcardPractice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:practice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is where a user will practice the flashcards that have been added.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FlashcardsService $flashcardsService)
    {
        // Ask from user to Authenticate
        $credentials = $this->askForAuthentication();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $this->askTheQuestions($user);
            $this->showResultBasedOnUser($flashcardsService, $user);
        } else {
            $this->error('Please check your credentials, there is something wrong here.');
        }
        return Command::SUCCESS;
    }


    /**
     * @param array $list
     * @param float $getCompletion
     * @return void
     */
    public function createANewTableInstanceWithCompletionFooterNoAnswerForQuestions(array $list, float $getCompletion): void
    {
        // Create a new Table instance.
        $table = new Table($this->output);

        // Set the table headers.
        $table->setHeaders([
            ['ID', 'Question', 'Hint', 'State']
        ]);

        // Create a new TableSeparator instance.
        $separator = new TableSeparator();

        // Set the contents of the table.
        $table->setRows([
            ...$list,
            $separator,
            [new TableCell('Completion', ['colspan' => 2]), new TableCell($getCompletion . '%', ['colspan' => 2])],
        ]);

        // Render the table to the output.
        $table->render();
    }

    /**
     * @return array
     */
    public function askForAuthentication(): array
    {
        $this->line('If you are a valid user lets continue');
        // block.albert@example.com
        $usernameOrEmail = $this->ask('What is your email?');
        // password
        $password = $this->secret('What is the password?');
        return ['email' => $usernameOrEmail, 'password' => $password];
    }
    /**
     * @param $user
     * @return void
     */
    public function askTheQuestions($user): void
    {
        $flashcards = Flashcards::select('id', 'question', 'hint', 'answer')->get();
        $bar = $this->output->createProgressBar(count($flashcards->toArray()));
        $bar->start();
        $this->line('');
        $this->createTheQuestionProgress($flashcards, $bar, $user);
        $bar->finish();
    }


    /**
     * @param mixed $flashcards
     * @param $bar
     * @param $user
     * @return void
     */
    public function createTheQuestionProgress(mixed $flashcards, $bar, $user): void
    {
        foreach ($flashcards as $flashcard) {
            if ($flashcard->getState() !== FlashcardsStates::STATE_CORRECT) {
                $this->askTheQuestion($flashcard, $bar, $user);
            } else {
                $this->info('<fg=bright-magenta>Question '.$flashcard->id.': This question was answered correctly before.</>');
                $bar->advance();
                $this->line('');
            }
        }
    }


    /**
     * @param FlashcardsService $flashcardsService
     * @param User|null $user
     * @return array
     */
    public function showResultBasedOnUser(FlashcardsService $flashcardsService, ?User $user = null): array
    {
        $list = $flashcardsService->getFlashcardsWithStats($user);
        $getCompletion = $flashcardsService->getCompletion($flashcardsService, $list);
        $this->createANewTableInstanceWithCompletionFooterNoAnswerForQuestions($list, $getCompletion);
        return $list;
    }

    /**
     * @param object $flashcard
     * @param $bar
     * @param $user
     * @return void
     */
    public function askTheQuestion(object $flashcard, $bar, $user): void
    {
        $answer = $this->ask('<fg=blue>Question '.$flashcard->id.': '.$flashcard->question . ' ( HINT: ' . $flashcard->hint . ')</>');
        $bar->advance();
        $this->line('');

        if ($answer) {
            $userAnswer = UsersAnswers::create([
                'flashcards_id' => $flashcard->id,
                'user_id' => $user->id,
                'answer' => $answer,
            ]);
        }
    }
}
