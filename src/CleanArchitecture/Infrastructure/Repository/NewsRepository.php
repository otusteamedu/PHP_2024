<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Repository;

use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;
use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use AlexanderGladkov\CleanArchitecture\Domain\ValueObject\Url;

class NewsRepository implements NewsRepositoryInterface
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function save(News $news): void
    {
        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }

    public function findByUrl(string $url): ?News
    {
        return $this->getRepository()->findOneBy(['url.value' => $url]);
    }

    public function findByIds(array $ids): array
    {
        return $this->getRepository()->findBy(['id' => $ids]);
    }

    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(News::class);
    }
}
