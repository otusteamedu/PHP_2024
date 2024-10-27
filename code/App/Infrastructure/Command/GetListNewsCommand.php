<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Application\UseCase\GetListNews\GetListNewsUseCase;
use App\Application\UseCase\GetListNews\GetListNewsRequest;

class GetListNewsCommand
{
    private GetListNewsUseCase $useCase;
    public function __construct(GetListNewsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(GetListNewsRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
