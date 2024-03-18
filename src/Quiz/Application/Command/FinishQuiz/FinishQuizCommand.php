<?php

declare(strict_types=1);

namespace App\Quiz\Application\Command\FinishQuiz;

use Symfony\Component\Uid\Uuid;

final class FinishQuizCommand
{
    public Uuid $quizResultId;
}