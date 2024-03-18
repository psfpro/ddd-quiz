<?php

declare(strict_types=1);

namespace App\Quiz\Application\Command\StartQuiz;

use App\Common\Bus\CommandHandler;
use App\Quiz\Domain\QuizResult\QuizResult;
use App\Quiz\Domain\QuizResult\Repository\QuizResultRepositoryInterface;
use Psr\Clock\ClockInterface;

final readonly class StartQuizCommandHandler implements CommandHandler
{
    public function __construct(
        private QuizResultRepositoryInterface $quizResultRepository,
        private ClockInterface $clock,
    ) {
    }

    public function __invoke(StartQuizCommand $command): void
    {
        $quizResult = new QuizResult(
            $command->quizResultId,
            $command->quizId,
            $command->quizName,
            $this->clock->now(),
        );
        $this->quizResultRepository->save($quizResult);
    }
}