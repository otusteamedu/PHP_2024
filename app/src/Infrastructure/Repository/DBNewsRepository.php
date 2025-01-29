<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class DBNewsRepository implements NewsRepositoryInterface
{
    private NewsMapper $newsMapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->newsMapper = new NewsMapper($pdo);
    }

    public function findAll(): iterable
    {
        // TODO: Implement findAll() method.
        return [];
    }

    public function save(News $news): void
    {
        // TODO: Implement save() method.
        $newsId = $this->newsMapper->insert($news);
        print_r($newsId);
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $newsId);
    }

    public function getReport(array $ids): string
    {
        // TODO: Implement delete() method.
        return "";
    }
}
