<?php

namespace App\Models\DTO;

class StatsResult
{
    private int $total;
    private int $answered;
    private int $correct;

    public function calculateCorrectAnsweredPercent(): float
    {
        return round(($this->getCorrect() / $this->getTotal()) * 100);
    }

    /**
     * @return int
     */
    public function getCorrect(): int
    {
        return $this->correct;
    }

    /**
     * @param int $correct
     */
    public function setCorrect(int $correct): void
    {
        $this->correct = $correct;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function calculateAnsweredPercent(): float
    {
        return round(($this->getAnswered() / $this->getTotal()) * 100);
    }

    /**
     * @return int
     */
    public function getAnswered(): int
    {
        return $this->answered;
    }

    /**
     * @param int $answered
     */
    public function setAnswered(int $answered): void
    {
        $this->answered = $answered;
    }
}
