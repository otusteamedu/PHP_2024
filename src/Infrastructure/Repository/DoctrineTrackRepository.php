<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Track;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineTrackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Track::class);
    }
}
