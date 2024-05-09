<?php

declare(strict_types=1);

namespace App\Domain\SearchGateway\Request;

/**
 * Request class.
 */
class SearchGatewayRequest
{
    /**
     * Construct Request.
     */
    public function __construct(
        public readonly string $query,
        public readonly int $gte,
        public readonly int $lte,
        public readonly string $category,
        public readonly string $shop
    ) {
    }
}
