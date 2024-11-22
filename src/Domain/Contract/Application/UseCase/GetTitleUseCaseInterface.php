<?php

namespace App\Domain\Contract\Application\UseCase;

use App\Application\UseCase\News\GetTitle\GetTitleUseCaseRequest;
use App\Application\UseCase\News\GetTitle\GetTitleUseCaseResponse;

interface GetTitleUseCaseInterface
{
    public function __invoke(GetTitleUseCaseRequest $request): GetTitleUseCaseResponse;
}
