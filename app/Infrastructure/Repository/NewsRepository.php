<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Contract\RepositoryInterface;
use App\Application\Exception\NewsNotCreatedException;
use App\Domain\Entity\News;
use App\Infrastructure\Database\Connection;

readonly class NewsRepository implements RepositoryInterface
{

    public function __construct(private Connection $pdo)
    {
    }

    /**
     * @throws NewsNotCreatedException
     */
    public function save(News $news): void
    {
        $rowCount = $this->pdo->execute('INSERT INTO news (date, url, title) VALUES (:date, :url, :title)', [
            'date' => $news->getDate(),
            'url' => $news->getUrl(),
            'title' => $news->getTitle(),
        ]);

        if (!$rowCount) {
            throw new NewsNotCreatedException('News not created');
        }
    }

    public function getAll(): array
    {
        $result = $this->pdo->queryAll(sql: 'SELECT * FROM news');

        return array_map(fn ($news) => $this->mapNews($news), $result);
    }

    public function getByIds(array $ids): array|false
    {
        $idsRaw = str_repeat('?,', count($ids) - 1) . '?';
        $result = $this->pdo->queryAll("SELECT * FROM news WHERE id IN ($idsRaw)", $ids);

        return array_map(fn ($news) => $this->mapNews($news), $result);
    }

    public function getLastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }

    private function mapNews(array $rawNews): News
    {
        $news = new News();
        $news->setDate($rawNews['date']);
        $news->setUrl($rawNews['url']);
        $news->setTitle($rawNews['title']);
        $news->setId($rawNews['id']);

        return $news;
    }
}
