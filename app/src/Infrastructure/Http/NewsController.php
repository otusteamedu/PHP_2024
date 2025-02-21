<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Hw15\Infrastructure\Http;

use AnatolyShilyaev\Hw15\Application\UseCase\CreateNews\CreateNewsRequest;
use AnatolyShilyaev\Hw15\Application\UseCase\CreateNews\CreateNewsResponse;
use AnatolyShilyaev\Hw15\Application\UseCase\CreateNews\CreateNewsUseCase;
use AnatolyShilyaev\Hw15\Application\UseCase\FindAllNews\FindAllNewsResponse;
use AnatolyShilyaev\Hw15\Application\UseCase\FindAllNews\FindAllNewsUseCase;
use AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews\GetReportNewsRequest;
use AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews\GetReportNewsResponse;
use AnatolyShilyaev\Hw15\Application\UseCase\GetReportNews\GetReportNewsUseCase;

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
