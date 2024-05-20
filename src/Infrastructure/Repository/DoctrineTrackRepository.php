<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Track;
use App\Domain\Repository\ITrackRepository;
use App\Domain\ValueObject\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineTrackRepository extends ServiceEntityRepository implements ITrackRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Track::class);
    }

    public function getTracksByGenre(Genre $genre): array
    {
        return $this
            ->createQueryBuilder('t')
            ->where('t.genre.value = :genre')
            ->setParameter('genre', $genre->getValue())
            ->getQuery()
            ->getResult();
    }

    public function save(Track $track): void
    {
        $this->getEntityManager()->persist($track);
        $this->getEntityManager()->flush();
    }
}
