<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Collection\TracksCollection;
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

    public function getTracksByGenre(Genre $genre): TracksCollection
    {
        $result = $this
            ->createQueryBuilder('t')
            ->where('t.genre.value = :genre')
            ->setParameter('genre', $genre->getValue())
            ->getQuery()
            ->getResult();

        return new TracksCollection($result);
    }

    public function findTracksById(array $ids): TracksCollection
    {
        $queryBuilder = $this->createQueryBuilder('t');
        $result = $queryBuilder
            ->where($queryBuilder->expr()->in('t.id', ':ids'))
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();

        return new TracksCollection($result);
    }


    public function save(Track $track): void
    {
        $this->getEntityManager()->persist($track);
        $this->getEntityManager()->flush();
    }
}
