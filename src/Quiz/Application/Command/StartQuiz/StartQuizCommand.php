<?php

declare(strict_types=1);

namespace App\Quiz\Application\Command\StartQuiz;

use Symfony\Component\Uid\Uuid;

final class StartQuizCommand
{
    public Uuid $quizResultId;
    public Uuid $quizId;
    public string $quizName;
}