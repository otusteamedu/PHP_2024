<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsUseCase;

class NewsController
{
    public function __construct(
        private CreateNewsUseCase $createUseCase,
        private FindAllNewsUseCase $findAllUseCase,
        private GetReportNewsUseCase $getReportUseCase,
    ) {
        // Empty constructor
    }

    public function create(CreateNewsRequest $request): CreateNewsResponse
    {
        try {
            $response = ($this->createUseCase)($request);
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function findall(): FindAllNewsResponse
    {
        try {
            $response = ($this->findAllUseCase)();
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function getReport(GetReportNewsRequest $ids): GetReportNewsResponse
    {
        try {
            $response = ($this->getReportUseCase)($ids);
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
