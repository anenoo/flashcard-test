<?php

namespace App\Services;

use App\Models\DTO\StatsResult;
use App\Models\Flashcards;
use App\Models\User;
use App\Models\UsersAnswers;

class FlashcardsService
{
    /**
     * @return StatsResult
     */
    public function calculateStats(): StatsResult
    {
        $totalQuestions = $this->getTotalFlashCardsCount();
        $totalAnsweredQuestion = $this->getTotalAnsweredQuestion();
        $totalCorrectAnswerQuestions = $this->getCorrectAnswerQuestions();

        $stateResult = new StatsResult();
        $stateResult->setTotal($totalQuestions);
        $stateResult->setAnswered($totalAnsweredQuestion);
        $stateResult->setCorrect($totalCorrectAnswerQuestions);
        return $stateResult;
    }

    /**
     * @return mixed
     */
    public function getTotalFlashCardsCount(): mixed
    {
        return Flashcards::select('id')->count();
    }

    /**
     * @return mixed
     */
    public function getTotalAnsweredQuestion(): mixed
    {
        return UsersAnswers::select('id', 'flashcards_id')
            ->groupBy('flashcards_id')
            ->get()->count();
    }

    /**
     * @return mixed
     */
    public function getCorrectAnswerQuestions(): mixed
    {
        return Flashcards::select(
            'users_answers.id',
            'users_answers.flashcards_id',
            'users_answers.answer as A1',
            'flashcards.id',
            'flashcards.answer as A2'
        )
            ->leftJoin('users_answers', 'users_answers.flashcards_id', '=', 'flashcards.id')
            ->whereRaw('flashcards.answer = users_answers.answer')
            ->get()->count();
    }


    /**
     * @return array
     */
    public function getFlashcardsWithAnswerAndStats(): array
    {
        $list = [];
        $flashcards = Flashcards::select('flashcards.id', 'question', 'flashcards.answer')->get();
        foreach ($flashcards as $card) {
            $list[] = [
                $card->id,
                $card->question,
                $card->answer,
                $card->getStylesState()
            ];
        }
        return $list;
    }

    /**
     * @param User|null $user
     * @return array
     */
    public function getFlashcardsWithStatsAndHint(?User $user = null): array
    {
        $list = [];
        $flashcards = Flashcards::select('flashcards.id', 'question', 'hint', 'flashcards.answer')->get();
        foreach ($flashcards as $card) {
            $list[] = [
                'id' => $card->id,
                'question' => $card->question,
                'hint' => $card->hint,
                'state' => $user ? $card->getStateByUser($user) : $card->getState()
            ];
        }
        return $list;
    }

    /**
     * @param array $list
     * @return float
     */
    public function getCompletion(array $list): float
    {
        $getCorrectAnswers = $this->getCorrectAnswerQuestions();
        $getTotalQuestions = count($list);

        $stateResult = new StatsResult();
        $stateResult->setTotal($getTotalQuestions);
        $stateResult->setCorrect($getCorrectAnswers);
        return $stateResult->calculateCorrectAnsweredPercent();
    }
}
