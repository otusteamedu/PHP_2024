<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsUseCase;

class FindAllNewsController
{
    public function __construct(
        private FindAllNewsUseCase $findAllUseCase,
    ) {
        // Empty constructor
    }

    public function findAll(): iterable | string
    {
        try {
            $response = ($this->findAllUseCase)();
            return $response;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
