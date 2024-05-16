<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateTrackRequest;
use App\Application\UseCase\Response\CreateTrackResponse;

class CreateTrackUseCase
{
    public function __invoke(CreateTrackRequest $request): CreateTrackResponse
    {
        return new CreateTrackResponse(1);
    }
}
