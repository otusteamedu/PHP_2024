<?php

namespace App\Domain\Contract\Application\UseCase;

use App\Application\UseCase\News\GetAllNews\GetAllNewsUseCaseResponse;

interface GetAllNewsUseCaseInterface
{
    /**
     * @return GetAllNewsUseCaseResponse[]
     */
    public function __invoke(): iterable;
}
