<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Infrastructure\Command;

use SlavaMakhov\OtusArchitectureApp\Application\UseCase\SubmitEventResponse;
use SlavaMakhov\OtusArchitectureApp\Application\UseCase\SubmitEventRequest;
use SlavaMakhov\OtusArchitectureApp\Application\UseCase\SubmitEventUseCase;

class SubmitEventCommand
{
    /**
     * @var SubmitEventUseCase
     */
    private SubmitEventUseCase $useCase;

    public function __construct(SubmitEventUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param SubmitEventRequest $request
     *
     * @return SubmitEventResponse
     */
    public function __invoke(SubmitEventRequest $request): SubmitEventResponse
    {
        return ($this->useCase)($request);
    }
}