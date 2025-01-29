<?php

namespace Anatolyshilyaev\Hw14\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use PDO;

class NewsMapper
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(News $news): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO news (title, date, url) 
            VALUES (:title, :date, :url)"
        );

        $stmt->execute([
            'title' => $news->getTitle()->getValue(),
            'date' => $news->getDate()->getValue(),
            'url' => $news->getUrl()->getValue(),
        ]);

        $id = (int) $this->pdo->lastInsertId();
        return $id;
    }

    public function findAll(): iterable
    {
        $stmt = $this->pdo->prepare("SELECT * FROM news");
        $stmt->execute();
        $news = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $news[] = $data;
        }

        return $news;
    }

    public function getReport(GetReportNewsRequest $request): iterable
    {
        $news = [];
        foreach ($request->ids as $id) {
            $stmt = $this->pdo->prepare("SELECT * FROM news WHERE id = :id");
            $stmt->execute(['id' => $id]);

            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $news[] = $data;
            }
        }
        return $news;
    }
}
