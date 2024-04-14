<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class AddNewsResponse
{

    public function __construct(public readonly int $id)
    {
    }
}