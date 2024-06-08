<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Infrastructure\Database;

use Kagirova\Hw21\Domain\Builder\NewsBuilder;
use Kagirova\Hw21\Domain\Config\Config;
use Kagirova\Hw21\Domain\Entity\News;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class PostgresStorage implements StorageInterface
{
    private \PDO $pdo;

    public function connect()
    {
        $config = new Config(dirname(__DIR__) . '/../../db/database.ini');
        $config->configPostgres();
        $dsn = "pgsql:host=" . $config->getHost() . ";port=" . $config->getPort() . ";dbname=" . $config->getDatabase();
        $this->pdo = new \PDO($dsn, $config->getUser(), $config->getPassword());
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getAllNews()
    {
        $news = [];
        $sql = 'SELECT * FROM news';

        $row = $this->pdo->query($sql, \PDO::FETCH_ASSOC);

        foreach ($row as $news_row) {
            $categoryName = $this->getCategoryName($news_row['category_id']);

            $newsBuilder = (new NewsBuilder())
                ->setId((int)$news_row['id'])
                ->setName($news_row['name'])
                ->setDate($news_row['date'])
                ->setAuthor($news_row['author'])
                ->setCategory($news_row['category_id'], $categoryName)
                ->setText($news_row['text']);
            array_push($news, $newsBuilder->build());
        }
        return $news;
    }

    public function getNews($newsId)
    {
        $sql = 'SELECT * FROM news WHERE id=:id';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $newsId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (empty($row)) {
            echo "No Results Found.";
        }
        $categoryName = $this->getCategoryName($row['category_id']);
        $newsBuilder = (new NewsBuilder())
            ->setId((int)$row['id'])
            ->setName($row['name'])
            ->setDate($row['date'])
            ->setAuthor($row['author'])
            ->setCategory($row['category_id'], $categoryName)
            ->setText($row['text']);

        $news = $newsBuilder->build();
        return $news;
    }

    public function saveNews(News $news): int
    {
        $sql = 'INSERT INTO news (name, category_id, date, author, text)  VALUES (:name, :category_id, :date, :author, :text)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $news->getName());
        $stmt->bindValue(':category_id', $news->getCategory()->getId());
        $stmt->bindValue(':date', $news->getDate());
        $stmt->bindValue(':author', $news->getAuthor());
        $stmt->bindValue(':text', $news->getText());
        $stmt->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function subscribeToNews($categoryId)
    {
        $sql = 'INSERT INTO subscription (category_id)  VALUES (:category_id)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId);
        $stmt->execute();
    }

    public function getCategoryId($categoryName)
    {
        $sql = 'SELECT id FROM category WHERE name=:name';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $categoryName);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (empty($row)) {
            return -1;
        }
        return $row['id'];
    }

    public function addCategory($categoryName)
    {
        $sql = 'INSERT INTO category (name)  VALUES (:name)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $categoryName);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function getCategoryName(int $categoryId)
    {
        $sql = 'SELECT name FROM category WHERE id=:id';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $categoryId);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (empty($row)) {
            return -1;
        }
        return $row['name'];
    }

    public function getAllSubscription()
    {
        $subscriptions = [];
        $sql = 'SELECT category_id FROM subscription';
        $row = $this->pdo->query($sql, \PDO::FETCH_ASSOC);

        foreach ($row as $subscriptions_row) {
            $subscriptions[] = $subscriptions_row['category_id'];
        }
        return $subscriptions;
    }
}
