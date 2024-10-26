<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Application\UseCase\GetNews\GetNewsRequest;
use App\Application\UseCase\GetNews\GetNewsUseCase;

class GetNewsCommand
{
    private GetNewsUseCase $useCase;
    public function __construct(GetNewsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(GetNewsRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
