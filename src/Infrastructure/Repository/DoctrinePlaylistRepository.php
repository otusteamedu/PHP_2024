<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

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

    /**
     * @param Email $user
     * @return Playlist[]
     */
    public function findPlaylistsByUser(Email $user): array
    {
        return $this
            ->createQueryBuilder('p')
            ->where('p.userName = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function save(Playlist $track): void
    {
        $this->getEntityManager()->persist($track);
        $this->getEntityManager()->flush();
    }
}
