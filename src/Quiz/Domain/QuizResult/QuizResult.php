<?php

declare(strict_types=1);

namespace App\Quiz\Domain\QuizResult;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

final class QuizResult
{
    private Uuid $id;
    private Uuid $quizId;
    private string $quizName;
    private \DateTimeImmutable $startTime;
    private ?\DateTimeImmutable $endTime;
    private Collection $questionResults;

    public function __construct(
        Uuid $id,
        Uuid $quizId,
        string $quizName,
        \DateTimeImmutable $startTime,
    ) {
        $this->id = $id;
        $this->quizId = $quizId;
        $this->quizName = $quizName;
        $this->startTime = $startTime;
        $this->endTime = null;
        $this->questionResults = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getQuizId(): Uuid
    {
        return $this->quizId;
    }

    public function getQuizName(): string
    {
        return $this->quizName;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getEndTime(): ?\DateTimeImmutable
    {
        return $this->endTime;
    }

    public function getQuestionResults(): Collection
    {
        return $this->questionResults;
    }

    public function getCorrectQuestionResults(): Collection
    {
        return $this->questionResults->filter(fn (QuestionResult $questionResult) => $questionResult->isCorrect());
    }

    public function getIncorrectQuestionResults(): Collection
    {
        return $this->questionResults->filter(fn (QuestionResult $questionResult) => !$questionResult->isCorrect());
    }

    public function finish(\DateTimeImmutable $now): void
    {
        $this->endTime = $now;
    }

    public function saveAnswer(Uuid $id, Uuid $questionId, string $questionText, bool $isCorrect): void
    {
        $questionResult = new QuestionResult($id, $questionId, $questionText, $isCorrect, $this);
        $this->questionResults->add($questionResult);
    }
}