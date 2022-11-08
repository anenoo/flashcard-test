<?php

namespace App\Models;

use App\Models\Constants\FlashcardsStates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcards extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'hint',
        'answer'
    ];

    public function usersAnswers()
    {
        return $this->hasMany(UsersAnswers::class);
    }

    public function getAnswersAsArray()
    {
        return $this->usersAnswers()->get()->toArray();
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        $usersAnswers = $this->getAnswersAsArray();
        if (count($usersAnswers)) {
            foreach ($usersAnswers as $userAnswer) {
                if ($userAnswer['answer'] === $this->answer) {
                    return FlashcardsStates::STATE_CORRECT;
                }
            }
            return FlashcardsStates::STATE_INCORRECT;
        }
        return FlashcardsStates::STATE_NOT_ANSWERED;
    }

    /**
     * @return string
     */
    public function getStateByUser(?User $user): string
    {
        $usersAnswers = $this->getAnswersAsArray();
        if (count($usersAnswers)) {
            $hasIncorrectAnswer = false;
            foreach ($usersAnswers as $userAnswer) {
                if ($user->id === $userAnswer['user_id']) {
                    if ($userAnswer['answer'] === $this->answer) {
                        return FlashcardsStates::STATE_CORRECT;
                    } else {
                        $hasIncorrectAnswer = true;
                    }
                }
            }
            if ($hasIncorrectAnswer) {
                return FlashcardsStates::STATE_INCORRECT;
            }
        }
        return FlashcardsStates::STATE_NOT_ANSWERED;
    }


    public function getStylesState(): string
    {
        return match ($this->getState()) {
            FlashcardsStates::STATE_CORRECT => '<info>' . FlashcardsStates::STATE_CORRECT . '</info>',
            FlashcardsStates::STATE_INCORRECT => '<bg=yellow;fg=black>' . FlashcardsStates::STATE_INCORRECT . '</>',
            default => '<error>' . FlashcardsStates::STATE_NOT_ANSWERED . '</error>',
        };
    }
}
