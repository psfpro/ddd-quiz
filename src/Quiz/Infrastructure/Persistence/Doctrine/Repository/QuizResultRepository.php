<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\Persistence\Doctrine\Repository;

use App\Quiz\Domain\Quiz\Quiz;
use App\Quiz\Domain\QuizResult\QuizResult;
use App\Quiz\Domain\QuizResult\Repository\QuizResultRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class QuizResultRepository extends ServiceEntityRepository implements QuizResultRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizResult::class);
    }

    public function findAll(): Collection
    {
        $qb = $this->createQueryBuilder('q');
        $result = $qb->getQuery()->getResult();
        assert(is_array($result));

        return new ArrayCollection($result);
    }

    public function findOneById(Uuid $id): ?QuizResult
    {
        $qb = $this->createQueryBuilder('q');
        $qb->where('q.id = :id')
            ->setParameters([
                'id' => $id,
            ]);
        /** @var Quiz|null $result */
        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }

    public function save(QuizResult $quizResult): void
    {
        $this->_em->persist($quizResult);
        $this->_em->flush();
    }
}