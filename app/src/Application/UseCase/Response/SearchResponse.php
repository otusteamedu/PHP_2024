<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

/**
 * Response class.
 */
class SearchResponse
{
    /**
     * Construct Response.
     */
    public function __construct(
        public readonly array $traces
    ) {
    }
}
