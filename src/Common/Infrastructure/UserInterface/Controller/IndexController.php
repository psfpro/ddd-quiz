<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\UserInterface\Controller;

use App\Quiz\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Quiz\Domain\QuizResult\Repository\QuizResultRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    public function __construct(
        private readonly QuizRepositoryInterface $quizRepository,
        private readonly QuizResultRepositoryInterface $quizResultRepository,
    ) {
    }
    #[Route('/', name: 'landing')]
    public function __invoke(Request $request): Response
    {
        $quizzes = $this->quizRepository->findAll();
        $results = $this->quizResultRepository->findAll();

        return $this->render('views/common/index.html.twig', [
            'quizzes' => $quizzes,
            'results' => $results,
        ]);
    }
}