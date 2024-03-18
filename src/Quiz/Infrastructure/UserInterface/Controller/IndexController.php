<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\UserInterface\Controller;

use App\Common\Bus\CommandBusInterface;
use App\Quiz\Application\Command\StartQuiz\StartQuizCommand;
use App\Quiz\Domain\Quiz\Repository\QuizRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class IndexController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QuizRepositoryInterface $quizRepository,
    ) {
    }

    #[Route('/quiz/{quizId}', name: 'quiz_start')]
    public function __invoke(Uuid $quizId): Response
    {
        $quiz = $this->quizRepository->findOneById($quizId);
        if ($quiz === null) {
            return $this->redirectToRoute('landing');
        }

        $command = new StartQuizCommand();
        $command->quizResultId = Uuid::v7();
        $command->quizId = $quiz->getId();
        $command->quizName = $quiz->getName();

        $this->commandBus->dispatch($command);

        return $this->redirectToRoute('quiz_question', [
            'quizResultId' => $command->quizResultId,
        ]);
    }
}