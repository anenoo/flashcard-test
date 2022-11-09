<?php

namespace App\Models;

use App\Models\Constants\FlashcardsStates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcards extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'question',
        'hint',
        'answer'
    ];

    /**
     * @return string
     */
    public function getStylesState(): string
    {
        return match ($this->getState()) {
            FlashcardsStates::STATE_CORRECT => FlashcardsStates::STATE_STYLED_CORRECT,
            FlashcardsStates::STATE_INCORRECT => FlashcardsStates::STATE_STYLED_INCORRECT,
            default => FlashcardsStates::STATE_NOT_ANSWERED,
        };
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
     * @return mixed
     */
    public function getAnswersAsArray(): mixed
    {
        return $this->usersAnswers()->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function usersAnswers(): mixed
    {
        return $this->hasMany(UsersAnswers::class);
    }

    /**
     * @param User|null $user
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
}
