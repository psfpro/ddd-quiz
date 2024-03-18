<?php

declare(strict_types=1);

namespace App\Quiz\Domain\QuizResult\Repository;

use App\Quiz\Domain\QuizResult\QuizResult;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

interface QuizResultRepositoryInterface
{
    public function findAll(): Collection;

    public function findOneById(Uuid $id): ?QuizResult;

    public function save(QuizResult $quizResult): void;
}