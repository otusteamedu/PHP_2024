<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsUseCase;

class GetReportNewsController
{
    public function __construct(
        private GetReportNewsUseCase $getReportUseCase,
    ) {
        // Empty constructor
    }

    public function getReport(GetReportNewsRequest $ids): GetReportNewsResponse | string
    {
        try {
            $response = ($this->getReportUseCase)($ids);
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
