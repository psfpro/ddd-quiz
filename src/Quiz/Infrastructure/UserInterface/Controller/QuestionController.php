<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\UserInterface\Controller;

use App\Common\Bus\CommandBusInterface;
use App\Quiz\Application\Command\AnswerQuestion\AnswerQuestionCommand;
use App\Quiz\Application\Command\FinishQuiz\FinishQuizCommand;
use App\Quiz\Application\Command\StartQuiz\StartQuizCommand;
use App\Quiz\Domain\Quiz\Answer;
use App\Quiz\Domain\Quiz\Question;
use App\Quiz\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Quiz\Domain\QuizResult\QuestionResult;
use App\Quiz\Domain\QuizResult\Repository\QuizResultRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class QuestionController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QuizRepositoryInterface $quizRepository,
        private readonly QuizResultRepositoryInterface $quizResultRepository,
    ) {
    }

    #[Route('/quiz/question/{quizResultId}', name: 'quiz_question')]
    public function __invoke(Request $request, Uuid $quizResultId): Response
    {
        $quizResult = $this->quizResultRepository->findOneById($quizResultId);
        $quiz = $this->quizRepository->findOneById($quizResult->getQuizId());
        if ($quiz === null) {
            return $this->redirectToRoute('landing');
        }

        $question = $quiz->findNextQuestion(
            $quizResult->getQuestionResults()->map(function (QuestionResult $questionResult) {
                return $questionResult->getQuestionId();
            })->toArray()
        );
        if ($question === null) {
            $command = new FinishQuizCommand();
            $command->quizResultId = $quizResultId;
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('quiz_result', ['quizResultId' => $quizResultId]);
        }

        $choices = [];
        /** @var Answer $answer */
        foreach ($question->getAnswers() as $answer) {
            $choices[$answer->getText()] = $answer->getId()->toRfc4122();
        }

        $command = new AnswerQuestionCommand();
        $command->questionResultId = Uuid::v7();
        $command->quizResultId = $quizResultId;
        $command->questionId = $question->getId();
        $form = $this->createFormBuilder($command)
            ->add('answer', ChoiceType::class, [
                'label' => 'Choose an answer',
                'multiple' => true,
                'expanded' => true,
                'choices' => $choices,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($command);
            return $this->redirectToRoute('quiz_question', [
                'quizResultId' => $command->quizResultId,
            ]);
        }

        return $this->render('views/quiz/question.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }
}