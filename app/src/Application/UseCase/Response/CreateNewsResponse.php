<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\Service\UseCaseResponseInterface;

readonly class CreateNewsResponse implements UseCaseResponseInterface
{
    public function __construct(private int $id)
    {
    }

    public function getData(): mixed
    {
        return $this->id;
    }
}
