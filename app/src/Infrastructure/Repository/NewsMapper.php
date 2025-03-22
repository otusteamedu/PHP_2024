<?php

namespace Anatolyshilyaev\Hw14\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use Anatolyshilyaev\Hw14\Infrastructure\Factory\NewsFactory;
use DateTimeImmutable;
use PDO;

class NewsMapper
{
    private PDO $pdo;
    private NewsFactory $factory;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->factory = new NewsFactory();
    }

    public function save(News $news): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO news (title, date, url) 
            VALUES (:title, :date, :url)"
        );

        $stmt->execute([
            'title' => $news->getTitle()->getValue(),
            'date' => $news->getDate()->getValue()->format('Y-m-d'),
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
            $news[] =  $this->hydrateNews($data);
        }

        return $news;
    }

    public function findByIds(GetReportNewsRequest $request): iterable
    {
        if (empty($request->ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($request->ids), '?'));
        $stmt = $this->pdo->prepare("SELECT * FROM news WHERE id IN ($placeholders)");
        $stmt->execute($request->ids);

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $news[] = $this->hydrateNews($data);
        }

        return $news;
    }

    private function hydrateNews(array $data): News
    {
        $title = new Title($data['title']);
        $date = new Date(new DateTimeImmutable($data['date']));
        $url = new Url($data['url']);

        return $this->factory->create($title, $date, $url);
    }
}
