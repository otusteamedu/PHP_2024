<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;

class NewsController
{
    public function __construct(
        private CreateNewsUseCase $useCase,
    ) {}


    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        try {
            $response = ($this->useCase)($request);
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return "";
    }
}
