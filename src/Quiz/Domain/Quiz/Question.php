<?php

declare(strict_types=1);

namespace App\Quiz\Domain\Quiz;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

final class Question
{
    private Uuid $id;
    private string $text;
    private Collection $answers;
    private Quiz $quiz;

    public function __construct(
        Uuid $id,
        string $text,
        Quiz $quiz,
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->answers = new ArrayCollection();
        $this->quiz = $quiz;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Uuid $answerId, string $text, bool $isCorrect): void
    {
        $answer = new Answer($answerId, $text, $isCorrect, $this);
        $this->answers->add($answer);
    }

    public function getAnswerById(Uuid $answerId): Answer
    {
        $answer = $this->answers->findFirst(function(int $key, Answer $answer) use ($answerId): bool {
            return $answer->getId()->equals($answerId);
        });

        if ($answer instanceof Answer) {
            return $answer;
        }

        throw new \InvalidArgumentException();
    }
}