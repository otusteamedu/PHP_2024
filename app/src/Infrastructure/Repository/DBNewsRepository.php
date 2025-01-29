<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;

class DBNewsRepository implements NewsRepositoryInterface
{

    public function findAll(): iterable
    {
        // TODO: Implement findAll() method.
        return [];
    }

    public function save(News $news): void
    {
        // TODO: Implement save() method.
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, 1);
    }

    public function getReport(array $ids): string
    {
        // TODO: Implement delete() method.
        return "";
    }
}
