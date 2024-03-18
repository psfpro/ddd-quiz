<?php

declare(strict_types=1);

namespace App\Quiz\Domain\Quiz;

use Symfony\Component\Uid\Uuid;

final class Answer
{
    private Uuid $id;
    private string $text;
    private bool $isCorrect;
    private Question $question;

    public function __construct(
        Uuid $id,
        string $text,
        bool $isCorrect,
        Question $question,
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->isCorrect = $isCorrect;
        $this->question = $question;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }
}