<?php

declare(strict_types=1);

namespace App\Quiz\Application\Command\FinishQuiz;

use App\Common\Bus\CommandHandler;
use App\Quiz\Application\Command\StartQuiz\StartQuizCommand;
use App\Quiz\Domain\QuizResult\QuizResult;
use App\Quiz\Domain\QuizResult\Repository\QuizResultRepositoryInterface;
use Psr\Clock\ClockInterface;

final readonly class FinishQuizCommandHandler implements CommandHandler
{
    public function __construct(
        private QuizResultRepositoryInterface $quizResultRepository,
        private ClockInterface $clock,
    ) {
    }

    public function __invoke(FinishQuizCommand $command): void
    {
        $quizResult = $this->quizResultRepository->findOneById($command->quizResultId);
        $quizResult->finish($this->clock->now());
        $this->quizResultRepository->save($quizResult);
    }
}