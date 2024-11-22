<?php

namespace App\Domain\Contract\Application\UseCase;

use App\Application\UseCase\News\CreateNews\CreateNewsUseCaseRequest;
use App\Application\UseCase\News\CreateNews\CreateNewsUseCaseResponse;

interface CreateNewsUseCaseInterface
{
    public function __invoke(CreateNewsUseCaseRequest $request): CreateNewsUseCaseResponse;
}
