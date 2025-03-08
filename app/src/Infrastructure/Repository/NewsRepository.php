<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    private NewsMapper $newsMapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->newsMapper = new NewsMapper($pdo);
    }

    public function findAll(): iterable
    {
        $news = $this->newsMapper->findAll();
        return $news;
    }

    public function save(News $news): void
    {
        $newsId = $this->newsMapper->save($news);
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsId);
    }

    public function findSome(GetReportNewsRequest $request): iterable
    {
        $news = $this->newsMapper->getReport($request);

        return $news;
    }
}
