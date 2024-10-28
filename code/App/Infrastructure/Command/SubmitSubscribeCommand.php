<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Application\UseCase\SubmitSubscribe\SubmitSubscribeRequest;
use App\Application\UseCase\SubmitSubscribe\SubmitSubscribeUseCase;

class SubmitSubscribeCommand
{
    private SubmitSubscribeUseCase $useCase;
    public function __construct(SubmitSubscribeUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function __invoke(SubmitSubscribeRequest $request)
    {
        $response = ($this->useCase)($request);
        return $response;
    }
}
