<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\DTO\SuccessSubscribedDto;

readonly class SubscribeNewGenreRecordsResponse
{
    public function __construct(
        public SuccessSubscribedDto $result,
    ) {
    }
}
