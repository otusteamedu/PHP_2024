<?php

namespace Anatolyshilyaev\Hw14\Domain\Repository;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Infrastructure\Repository\NewsMapper;

interface NewsRepositoryInterface
{
    public function findAll(): iterable;

    public function findByIds(GetReportNewsRequest $ids): iterable;

    public function save(News $news): void;
}
