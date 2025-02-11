<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepository;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineNews;
use App\Infrastructure\Persistence\Doctrine\Mapper\NewsMapper;
use Doctrine\ORM\EntityManagerInterface;

readonly class DoctrineNewsRepository implements NewsRepository
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private NewsMapper             $mapper
    )
    {
    }

    public function save(News $news): void
    {
        $doctrineNews = $this->mapper->toDoctrine($news);

        $this->entityManager->persist($doctrineNews);
        $this->entityManager->flush();

        $news->setId($doctrineNews->getId());
    }

    public function getNewsByIds(iterable $ids): array
    {
        return $this->entityManager->getRepository(DoctrineNews::class)
            ->findBy(['id' => $ids]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(DoctrineNews::class)
            ->findAll();
    }
}