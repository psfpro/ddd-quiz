<?php

declare(strict_types=1);

namespace App\Quiz\Domain\QuizResult;

use Symfony\Component\Uid\Uuid;

final class QuestionResult
{
    private Uuid $id;
    private Uuid $questionId;
    private string $questionText;
    private bool $isCorrect;
    private QuizResult $quizResult;

    public function __construct(
        Uuid $id,
        Uuid $questionId,
        string $questionText,
        bool $isCorrect,
        QuizResult $quizResult,
    )
    {
        $this->id = $id;
        $this->questionId = $questionId;
        $this->questionText = $questionText;
        $this->isCorrect = $isCorrect;
        $this->quizResult = $quizResult;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getQuestionId(): Uuid
    {
        return $this->questionId;
    }

    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function getQuizResult(): QuizResult
    {
        return $this->quizResult;
    }
}
