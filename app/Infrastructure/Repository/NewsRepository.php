<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\EntityInterface;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\News;
use App\Infrastructure\Database\Connection;

readonly class NewsRepository implements RepositoryInterface
{

    public function __construct(private Connection $pdo)
    {
    }

    public function save(array $dataRaw): EntityInterface
    {
        $this->pdo->execute('INSERT INTO news (date, url, title) VALUES (:date, :url, :title)', [
            'date' => $dataRaw['date'],
            'url' => $dataRaw['url'],
            'title' => $dataRaw['title'],
        ]);

        return new News(
            (int)$this->pdo->lastInsertId(),
            $dataRaw['date'],
            $dataRaw['url'],
            $dataRaw['title'],
        );
    }

    public function getAll(): array|false
    {
        return $this->pdo->queryAll('SELECT * FROM news');
    }

    public function getByIds(array $ids): array|false
    {
        $idsRaw = str_repeat('?,', count($ids) - 1) . '?';
        return $this->pdo->queryAll(
            "SELECT * FROM news WHERE id IN ($idsRaw)",
            $ids
        );
    }
}
