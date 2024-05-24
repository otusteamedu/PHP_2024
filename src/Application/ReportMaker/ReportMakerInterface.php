<?php

declare(strict_types=1);

namespace App\Application\ReportMaker;

use App\Application\UseCase\Request\NewsItemRequest;
use App\Application\UseCase\Response\MakeReportResponse;

interface ReportMakerInterface
{
    /**
     * @param NewsItemRequest[] $newsList
     */
    public function makeReport(array $newsList): MakeReportResponse;
}