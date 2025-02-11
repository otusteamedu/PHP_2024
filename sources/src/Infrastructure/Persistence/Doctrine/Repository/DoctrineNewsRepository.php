<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepository;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineNews;
use App\Infrastructure\Persistence\Doctrine\Mapper\NewsMapper;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineNewsRepository implements NewsRepository
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private readonly NewsMapper    $mapper
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

    public function getNewsByIds(iterable $ids): iterable
    {
        // TODO: Implement getNewsByIds() method.
    }

    public function findAll(): iterable
    {
        // TODO: Implement findAll() method.
    }
}