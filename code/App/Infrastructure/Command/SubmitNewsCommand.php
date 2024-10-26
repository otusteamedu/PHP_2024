<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Application\UseCase\SubmitNews\SubmitNewsRequest;
use App\Application\UseCase\SubmitNews\SubmitNewsUseCase;

class SubmitNewsCommand
{
    private SubmitNewsUseCase $useCase;
    public function __construct(SubmitNewsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(SubmitNewsRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
