<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    public function __construct(
        private NewsMapper $newsMapper
    ) {
        // Empty constructor
    }

    /**
     * @param News $news
     * @return void
     */
    public function save(News $news): void
    {
        $newsId = $this->newsMapper->save($news);
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsId);
    }

    /**
     * @return News[]
     */
    public function findAll(): iterable
    {
        $news = $this->newsMapper->findAll();
        return $news;
    }

    /**
     * @param GetReportNewsRequest $request
     * @return News[]
     */
    public function findByIds(GetReportNewsRequest $request): iterable
    {
        $news = $this->newsMapper->findByIds($request);
        return $news;
    }
}
