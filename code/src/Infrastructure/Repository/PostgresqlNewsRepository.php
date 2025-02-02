<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Infrastructure\Repository;

use Asyrovatkin\Hw14\Domain\Entity\News;
use Asyrovatkin\Hw14\Domain\Repository\NewsRepositoryInterface;
use Asyrovatkin\Hw14\Domain\ValueObject\Url;
use Asyrovatkin\Hw14\Infrastructure\Database\Postgesql\DbConnection;
use PDO;

class PostgresqlNewsRepository implements NewsRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $postgres = new DbConnection();
        $this->pdo = $postgres->getConnection();
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM news");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, News::class);
    }

    /**
     * @inheritDoc
     */
    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }
        $idsToQuery = implode(',', $ids);
        $query = $this->pdo->prepare("SELECT * FROM news WHERE id IN ({$idsToQuery})");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, News::class);
    }

    public function save(News $news): News
    {
        $query = $this->pdo
            ->prepare('INSERT INTO news (url, title, date) VALUES (:url, :title, :date) RETURNING id');
        $query->execute([
            'url' => $news->getUrl()->getValue(),
            'title' => $news->getTitle(),
            'date' => $news->getDate(),
        ]);

        $id = $query->fetch(PDO::FETCH_COLUMN);

        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $id);
        return $news;
    }
}