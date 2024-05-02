<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\GetNewsListResponse;

class GetNewsListUseCase
{
    public function __invoke(): GetNewsListResponse
    {
        return new GetNewsListResponse([]);
    }
}
