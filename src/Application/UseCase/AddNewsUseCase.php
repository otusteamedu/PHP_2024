<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;

class AddNewsUseCase
{
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        return new AddNewsResponse();
    }
}
