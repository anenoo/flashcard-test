<?php

namespace App\Models\Constants;

class FlashcardsStates
{
    public const STATE_NOT_ANSWERED = 'Not answered';
    public const STATE_CORRECT = 'Correct';
    public const STATE_INCORRECT = 'Incorrect';

    public const STATE_STYLED_NOT_ANSWERED = '<error>' . self::STATE_NOT_ANSWERED . '</error>';
    public const STATE_STYLED_CORRECT = '<info>' . self::STATE_CORRECT . '</info>';
    public const STATE_STYLED_INCORRECT = '<bg=yellow;fg=black>' . self::STATE_INCORRECT . '</>';
}
