<?php

declare(strict_types=1);

namespace App\Quiz\Domain\Quiz;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

final class Quiz
{
    private Uuid $id;
    private string $name;
    private string $description;
    private Collection $questions;

    public function __construct(
        Uuid $id,
        string $name,
        string $description,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->questions = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function findNextQuestion(array $excludeIds): ?Question
    {
        return $this->questions->findFirst(function(int $key, Question $question) use ($excludeIds): bool {
            foreach ($excludeIds as $id) {
                if ($question->getId()->equals($id)) {
                    return false;
                }
            }

            return true;
        });
    }

    public function addQuestion(Uuid $questionId, string $text): void
    {
        $question = new Question($questionId, $text, $this);
        $this->questions->add($question);
    }

    public function addQuestionAnswer(Uuid $questionId, Uuid $answerId, string $text, bool $isCorrect): void
    {
        $question = $this->getQuestionById($questionId);
        $question->addAnswer($answerId, $text, $isCorrect);
    }

    public function getQuestionById(Uuid $questionId): Question
    {
        $question = $this->questions->findFirst(function(int $key, Question $question) use ($questionId): bool {
            return $question->getId()->equals($questionId);
        });

        if ($question instanceof Question) {
            return $question;
        }

        throw new \InvalidArgumentException();
    }

    public function checkAnswer(Uuid $questionId, array $answerIds): bool
    {
        $question = $this->getQuestionById($questionId);

        foreach ($answerIds as $answerId) {
            $answer = $question->getAnswerById($answerId);
            if (!$answer->isCorrect()) {
                return false;
            }
        }

        return true;
    }
}