<?php

declare(strict_types=1);

namespace App\Quiz\Domain\Quiz\Repository;

use App\Quiz\Domain\Quiz\Quiz;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

interface QuizRepositoryInterface
{
    public function findAll(): Collection;

    public function findOneById(Uuid $id): ?Quiz;

    public function save(Quiz $quiz): void;
}