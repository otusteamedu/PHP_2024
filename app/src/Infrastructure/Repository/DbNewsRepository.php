<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Infrastructure\Repository;

use PavelMiasnov\MediaMonitoring\Domain\Entity\News;
use PavelMiasnov\MediaMonitoring\Domain\Repository\NewsRepositoryInterface;
use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Title;
use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Url;
use PDO;

class DbNewsRepository implements NewsRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(News $news): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO news (date, url, title) VALUES (:date, :url, :title)
            RETURNING id
        ");

        $stmt->execute([
            ':date' => $news->getDate()->format('Y-m-d H:i:s'),
            ':url' => $news->getUrl()->getValue(),
            ':title' => $news->getTitle()->getValue(),
        ]);
        $result = $stmt->fetchColumn();

        $reflectionPropertyId = new \ReflectionProperty(News::class, 'id');
        $reflectionPropertyId->setAccessible(true);
        $reflectionPropertyId->setValue($news, $result);
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM news";
        $stmt = $this->pdo->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $newsList = [];
        foreach ($results as $row) {
            $news = new News(
                new Url($row['url']),
                new Title($row['title']),
                new \DateTime($row['date'])
            );
            $reflectionPropertyId = new \ReflectionProperty(News::class, 'id');
            $reflectionPropertyId->setAccessible(true);
            $reflectionPropertyId->setValue($news, $row['id']);
            $newsList[] = $news;
        }

        return $newsList;
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT * FROM news WHERE id IN ($placeholders)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($ids);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $newsList = [];
        foreach ($results as $row) {
            $newsList[] = new News(
                new Url($row['url']),
                new Title($row['title']),
                new \DateTime($row['date'])
            );
        }

        return $newsList;
    }
}
