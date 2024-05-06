<?php

declare(strict_types=1);

namespace App\Application\ReportMaker;

use App\Application\UseCase\Request\NewsItemRequest;

interface ReportMakerInterface
{
    /**
     * @param NewsItemRequest[] $newsList
     * @return string Путь к файлу отчета
     */
    public function makeReport(array $newsList): string;
}