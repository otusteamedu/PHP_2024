<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Application\UseCase\SubmitEvent\SubmitEventUseCase;
use App\Application\UseCase\SubmitEvent\SubmitEventRequest;

class SubmitEventCommand
{
    private SubmitEventUseCase $useCase;
    public function __construct(SubmitEventUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(SubmitEventRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
