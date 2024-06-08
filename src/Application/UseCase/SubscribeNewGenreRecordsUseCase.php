<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\SubscribeNewGenreRecordsRequest;
use App\Application\UseCase\Response\SubscribeNewGenreRecordsResponse;

class SubscribeNewGenreRecordsUseCase
{
    public function __invoke(SubscribeNewGenreRecordsRequest $request): SubscribeNewGenreRecordsResponse
    {
        return new SubscribeNewGenreRecordsResponse();
    }
}
