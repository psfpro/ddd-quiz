<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\UserInterface\Controller;

use App\Common\Bus\CommandBusInterface;
use App\Quiz\Application\Command\StartQuiz\StartQuizCommand;
use App\Quiz\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Quiz\Domain\QuizResult\Repository\QuizResultRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class ResultController extends AbstractController
{
    public function __construct(
        private readonly QuizResultRepositoryInterface $quizResultRepository,
    ) {
    }

    #[Route('/quiz/result/{quizResultId}', name: 'quiz_result')]
    public function __invoke(Uuid $quizResultId): Response
    {
        $quizResult = $this->quizResultRepository->findOneById($quizResultId);

        return $this->render('views/quiz/result.html.twig', [
            'quizResult' => $quizResult,
        ]);
    }
}