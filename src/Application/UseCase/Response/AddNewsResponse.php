<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class AddNewsResponse
{

    public function __construct(public int $id)
    {
    }
}