<?php

declare(strict_types=1);

namespace Irayu\Hw13\Application\UseCase\Response;

class FindCompetitionsResponse
{
    public function __construct(
        public readonly array $competitions,
    ) {
    }
}
