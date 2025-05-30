<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;

class CreateNewsController
{
    public function __construct(
        private CreateNewsUseCase $createUseCase,
    ) {
        // Empty constructor
    }

    public function create(CreateNewsRequest $request): CreateNewsResponse | string
    {
        try {
            $response = ($this->createUseCase)($request);
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
