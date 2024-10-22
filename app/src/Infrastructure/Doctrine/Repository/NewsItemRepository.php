<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Infrastructure\Doctrine\Entity\NewsItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NewsItemRepository extends ServiceEntityRepository
{
    public function __construct(public readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsItem::class);
    }
}
