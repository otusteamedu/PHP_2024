<?php

namespace AnatolyShilyaev\Hw15\Domain\Repository;

use AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews\GetReportNewsRequest;
use AnatolyShilyaev\Hw15\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function findAll(): iterable;

    public function save(News $news): void;

    public function getReport(GetReportNewsRequest $ids): string;
}
