<?php

declare(strict_types=1);

namespace Pozys\Php2024\DataMapper;

use PDO;
use PDOStatement;
use Pozys\Php2024\Entity\News;
use Pozys\Php2024\IdentityMap;
use Pozys\Php2024\ValueObject\{NewsTitle, Url};

class NewsMapper
{
    private const TABLE = 'news';

    private PDOStatement $selectStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $deleteStatement;

    public function __construct(private PDO $pdo, private IdentityMap $identityMap)
    {
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM ' . self::TABLE . ' WHERE id = ?'
        );
        $this->selectStatement->setFetchMode(PDO::FETCH_OBJ);

        $this->insertStatement = $pdo->prepare(
            'INSERT INTO ' . self::TABLE . ' (url, title) VALUES (?, ?)'
        );

        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM ' . self::TABLE . ' WHERE id = ?'
        );
    }

    public function insert(News $news): News
    {
        $this->insertStatement->execute([
            $news->getUrl()->getValue(),
            $news->getTitle()->getValue(),
        ]);

        $id = (int)$this->pdo->lastInsertId();

        if (false === $id) {
            throw new \RuntimeException('Failed to insert news');
        }

        $news = $this->findById($id);
        $this->identityMap->add($news, $id);

        return $news;
    }

    public function update(int $id, array $data): void
    {
        if (count($data) === 0) {
            return;
        }

        $updateFields = implode(
            ', ',
            array_map(static fn (string $property) => "$property = ?", array_keys($data))
        );

        $updateStatement = $this->pdo->prepare(
            'UPDATE ' . self::TABLE . ' SET ' . $updateFields . ' WHERE id = ?'
        );

        if (!$updateStatement->execute([...array_values($data), $id])) {
            throw new \RuntimeException('Failed to update news with id ' . $id);
        }

        $news = $this->findById($id);
        $this->identityMap->add($news, $id);
    }

    public function findById(int $id): ?News
    {
        if ($this->identityMap->hasObject(News::class, $id)) {
            return $this->identityMap->get(News::class, $id);
        }

        $this->selectStatement->execute([$id]);

        $newsData = $this->selectStatement->fetch();

        if (!$newsData) {
            return null;
        }

        $news = $this->createNews($newsData);

        $this->identityMap->add($news, $id);

        return $news;
    }

    public function delete(News $news): void
    {
        if (!$this->deleteStatement->execute([$news->getId()])) {
            throw new \RuntimeException('Failed to delete news with id ' . $news->getId());
        }

        $this->identityMap->remove(News::class, $news->getId());
    }

    private function createNews(object $source): News
    {
        return (new News(new Url($source->url), new NewsTitle($source->title)))
            ->setId($source->id)
            ->setDate($source->date);
    }
}
