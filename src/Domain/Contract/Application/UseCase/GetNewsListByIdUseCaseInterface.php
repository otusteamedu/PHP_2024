<?php

namespace App\Domain\Contract\Application\UseCase;

use App\Application\UseCase\News\GetNewsListByIdArray\GetNewsListByIdUseCaseRequest;
use App\Application\UseCase\News\GetNewsListByIdArray\GetNewsListByIdUseCaseResponse;

interface GetNewsListByIdUseCaseInterface
{
    /**
     * @return GetNewsListByIdUseCaseResponse[]
     */
    public function __invoke(GetNewsListByIdUseCaseRequest $request): iterable;
}
