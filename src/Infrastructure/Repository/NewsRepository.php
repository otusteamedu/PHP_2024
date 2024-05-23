<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\Query\NewsByIdsQuery;
use Doctrine\ORM\EntityManagerInterface;

readonly class NewsRepository implements NewsRepositoryInterface
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function add(News $news): void
    {
        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }

    /**
     * @return list<News>
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(News::class)->findAll();
    }

    /**
     * @param NewsByIdsQuery $query
     * @return list<News>
     */
    public function findByIds(NewsByIdsQuery $query): array
    {
        return $this->entityManager->getRepository(News::class)->findBy(['id' => $query->ids]);
    }
}
