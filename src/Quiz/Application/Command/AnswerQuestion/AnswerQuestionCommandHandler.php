<?php

declare(strict_types=1);

namespace App\Quiz\Application\Command\AnswerQuestion;

use App\Common\Bus\CommandHandler;
use App\Quiz\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Quiz\Domain\QuizResult\Repository\QuizResultRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final readonly class AnswerQuestionCommandHandler implements CommandHandler
{
    public function __construct(
        private QuizRepositoryInterface $quizRepository,
        private QuizResultRepositoryInterface $quizResultRepository,
    ) {
    }

    public function __invoke(AnswerQuestionCommand $command): void
    {
        $quizResult = $this->quizResultRepository->findOneById($command->quizResultId);
        $quiz = $this->quizRepository->findOneById($quizResult->getQuizId());
        $question = $quiz->getQuestionById($command->questionId);

        $answerIds = array_map(function (string $answer) {
            return Uuid::fromString($answer);
        }, $command->answer);
        $result = $quiz->checkAnswer($command->questionId, $answerIds);

        $quizResult->saveAnswer($command->questionResultId, $command->questionId, $question->getText(), $result);

        $this->quizResultRepository->save($quizResult);
    }
}