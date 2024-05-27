<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response\DTO;

readonly class AddedNewsDto
{
    public function __construct(
        public int $id,
    ) {
    }
}
