<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\UseCase\Response;

use Irayu\Hw15\Domain;

class CreateReportNewsItemResponse implements DefaultNewsItemResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $hash,
    )
    {
    }
}