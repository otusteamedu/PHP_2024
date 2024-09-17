<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use Doctrine\ORM\EntityManagerInterface;

class NewsRepository implements NewsRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findAll(): array
    {
        $result = $this->entityManager->getConnection()->fetchAllAssociative('SELECT * FROM news');

        return array_map(fn($row) => $this->hydrate($row), $result);
    }

    public function findByIds(array $ids): array
    {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $result = $this->entityManager->getConnection()->fetchAllAssociative(
            'SELECT * FROM news WHERE id IN (' . $placeholders . ')',
            $ids
        );

        return array_map(fn($row) => $this->hydrate($row), $result);
    }

    public function findById(int $id): ?News
    {
        $row = $this->entityManager->getConnection()->fetchAssociative('SELECT * FROM news WHERE id = :id', ['id' => $id]);

        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function save(News $news): void
    {
        if ($news->getId() === null) {
            $this->entityManager->getConnection()->insert('news', [
                'title' => $news->getTitle()->getValue(),
                'url' => $news->getUrl()->getValue(),
                'date' => $news->getDate()->getValue()->format('Y-m-d H:i:s'),
            ]);

            $id = $this->entityManager->getConnection()->lastInsertId();

            $reflectionProperty = new \ReflectionProperty(News::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($news, (int) $id);
        } else {
            $this->entityManager->getConnection()->update('news', [
                'title' => $news->getTitle()->getValue(),
                'url' => $news->getUrl()->getValue(),
                'date' => $news->getDate()->getValue()->format('Y-m-d H:i:s'),
            ], ['id' => $news->getId()]);
        }

        $this->entityManager->flush();
    }


    public function delete(News $news): void
    {
        if ($news->getId() === null) {
            throw new \InvalidArgumentException('News must have an ID to be deleted');
        }

        $this->entityManager->getConnection()->delete('news', ['id' => $news->getId()]);
        $this->entityManager->flush();
    }

    private function hydrate(array $row): News
    {
        $news = new News(
            new Date(new \DateTimeImmutable($row['date'])),
            new Url($row['url']),
            new Title($row['title']),
        );

        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, (int) $row['id']);

        return $news;
    }
}
