<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\Persistence\Doctrine\Repository;

use App\Quiz\Domain\Quiz\Quiz;
use App\Quiz\Domain\Quiz\Repository\QuizRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class QuizRepository extends ServiceEntityRepository implements QuizRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function findAll(): Collection
    {
        $qb = $this->createQueryBuilder('q');
        $result = $qb->getQuery()->getResult();
        assert(is_array($result));

        return new ArrayCollection($result);
    }

    public function findOneById(Uuid $id): ?Quiz
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

    public function save(Quiz $quiz): void
    {
        $this->_em->persist($quiz);
        $this->_em->flush();
    }
}