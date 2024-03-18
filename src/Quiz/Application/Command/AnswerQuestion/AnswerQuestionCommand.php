<?php

declare(strict_types=1);

namespace App\Quiz\Application\Command\AnswerQuestion;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final class AnswerQuestionCommand
{
    public Uuid $questionResultId;
    public Uuid $quizResultId;
    public Uuid $questionId;
    #[Assert\NotBlank]
    public array $answer;
}