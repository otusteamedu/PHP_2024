<?php

namespace Anatolyshilyaev\Hw14\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use PDO;

class NewsMapper
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(News $news): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO news (title, date, url) 
            VALUES (:title, :date, :url)
        ');

        $stmt->execute([
            'title' => $news->getTitle(),
            'date' => $news->getDate(),
            'url' => $news->getUrl(),
        ]);

        $id = (int) $this->pdo->lastInsertId();
        return $id;
    }

    // public function find($id): ?News
    // {

    //     $stmt = $this->pdo->prepare('SELECT * FROM movies WHERE id = :id');
    //     $stmt->execute(['id' => $id]);
    //     $data = $stmt->fetch(PDO::FETCH_ASSOC);
    //     if ($data) {
    //         $movie = new Movie(
    //             $data['id'] ?? null,
    //             $data['name'] ?? null,
    //         );
    //         return $movie;
    //     }

    //     return null;
    // }

    // public function findAll(int $limit = 30, int $offset = 0): array
    // {
    //     print_r($offset + $limit);
    //     $stmt = $this->pdo->prepare("SELECT * FROM news WHERE id > ? ORDER BY id LIMIT ?");
    //     $stmt->execute([$offset, $limit,]);
    //     $movies = [];

    //     while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         $movie = new News(
    //             $data['id'] ?? null,
    //             $data['title'] ?? null,
    //             $data['title'] ?? null,
    //         );
    //         $movies[] = $movie;
    //     }

    //     return $movies;
    // }

    public function update(News $news, string $newTitle): bool
    {
        $stmt = $this->pdo->prepare('UPDATE news SET title = :title WHERE id = :id');

        $result = $stmt->execute([
            'title' => $newTitle,
            'id' => $news->getId(),
        ]);

        return $result;
    }

    public function delete($id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM news WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
