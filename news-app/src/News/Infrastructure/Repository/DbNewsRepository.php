<?php

declare(strict_types=1);

namespace App\News\Infrastructure\Repository;

use App\Common\Domain\ValueObject\DateTime;
use App\Entity\NewsCategory;
use App\News\Domain\Builder\NewsBuilder;
use App\News\Domain\Entity\News;
use App\News\Domain\Repository\NewsRepositoryInterface;
use App\News\Domain\ValueObject\Content;
use App\News\Domain\ValueObject\Title;
use App\NewsCategory\Domain\Entity\Category;
use App\NewsCategory\Domain\ValueObject\Name;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News as DoctrineNews;
use App\Entity\Category as DoctrineCategory;

class DbNewsRepository implements NewsRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(News $news): void
    {
        $doctrineNews = (new DoctrineNews())
            ->setTitle($news->getTitle()->value())
            ->setContent($news->getContent()->value())
            ->setCreatedAt($news->getCreatedAt());

        $this->entityManager->persist($doctrineNews);

        $doctrineCategory = $this
            ->entityManager
            ->getRepository(DoctrineCategory::class)
            ->find($news->getCategory()->getId());

        $doctrineNewsCategory = (new NewsCategory())
            ->setCategory($doctrineCategory)
            ->setNews($doctrineNews);

        $this->entityManager->persist($doctrineNewsCategory);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?News
    {
        $doctrineNews = $this
            ->entityManager
            ->getRepository(DoctrineNews::class)
            ->find($id);

        if ($doctrineNews === null) {
            return null;
        }

        return $this->getNewsFromDatabaseEntity($doctrineNews);
    }

    public function findAll(): array
    {
        $doctrineNews = $this
            ->entityManager
            ->getRepository(DoctrineNews::class)
            ->findAll();

        $news = [];

        foreach ($doctrineNews as $doctrineNewsEntity) {
            $news[] = $this->getNewsFromDatabaseEntity($doctrineNewsEntity);
        }

        return $news;
    }

    private function getNewsFromDatabaseEntity(DoctrineNews $news): News
    {
        $newsCategory = $news->getNewsCategories()->first();
        $category = $newsCategory->getCategory();

        $builder = (new NewsBuilder())
            ->setId($news->getId())
            ->setTitle(Title::fromString($news->getTitle()))
            ->setContent(Content::fromString($news->getContent()))
            ->setCreatedAt(new DateTime($news->getCreatedAt()));

        if ($category) {
            $builder
                ->setCategory(new Category($category->getId(), Name::fromString($category->getName())));
        }

        return $builder->build();
    }
}