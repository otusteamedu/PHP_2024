<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Collection\PlaylistCollection;
use App\Domain\Entity\Playlist;
use App\Domain\Repository\IPlaylistRepository;
use App\Domain\ValueObject\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrinePlaylistRepository extends ServiceEntityRepository implements IPlaylistRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    public function findPlaylistsByUser(Email $user): PlaylistCollection
    {
        $result = $this
            ->createQueryBuilder('p')
            ->select('p', 't')
            ->leftJoin('p.tracks', 't')
            ->where('p.userEmail.value = :user')
            ->setParameter('user', $user->getValue())
            ->getQuery()
            ->getResult();

        return new PlaylistCollection($result);
    }

    public function save(Playlist $track): void
    {
        $this->getEntityManager()->persist($track);
        $this->getEntityManager()->flush();
    }
}
