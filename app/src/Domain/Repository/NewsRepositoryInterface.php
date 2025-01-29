<?php

namespace Anatolyshilyaev\Hw14\Domain\Repository;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function findAll(): iterable;

    public function save(News $news): void;

    public function getReport(GetReportNewsRequest $ids): string;
}
