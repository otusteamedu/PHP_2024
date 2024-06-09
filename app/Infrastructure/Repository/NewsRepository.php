<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Exception\NewsNotCreatedException;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\News;
use App\Infrastructure\Database\Connection;
use ReflectionException;

readonly class NewsRepository implements RepositoryInterface
{

    public function __construct(private Connection $pdo)
    {
    }

    /**
     * @throws NewsNotCreatedException
     * @throws ReflectionException
     */
    public function save($entity): int
    {
        $rowCount = $this->pdo->execute('INSERT INTO news (date, url, title) VALUES (:date, :url, :title)', [
            'date' => $entity->getDate(),
            'url' => $entity->getUrl(),
            'title' => $entity->getTitle(),
        ]);

        if (!$rowCount) {
            throw new NewsNotCreatedException('News not created');
        }

        $this->setId($entity, $this->pdo->lastInsertId());

        return $entity->getId();
    }

    public function getAll(): array
    {
        $result = $this->pdo->queryAll(sql: 'SELECT * FROM news');

        return array_map(
        /**
         * @throws ReflectionException
         */ fn ($news) => $this->mapNews($news), $result);
    }

    public function getByIds(array $ids): array
    {
        $idsRaw = str_repeat('?,', count($ids) - 1) . '?';
        $result = $this->pdo->queryAll("SELECT * FROM news WHERE id IN ($idsRaw)", $ids);

        return array_map(
        /**
         * @throws ReflectionException
         */ fn ($news) => $this->mapNews($news), $result);
    }

    /**
     * @throws ReflectionException
     */
    private function mapNews(array $rawNews): News
    {
        $news = new News($rawNews['date'], $rawNews['url'], $rawNews['title']);
        $this->setId($news, $rawNews['id']);

        return $news;
    }

    /**
     * @throws ReflectionException
     */
    private function setId(News $news, int $id): void
    {
        (new \ReflectionClass($news))
            ->getProperty('id')
            ->setValue($news, $id);
    }
}
