<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

/**
 * Request class.
 */
class SearchRequest
{
    /**
     * Construct Request.
     */
    public function __construct(
        public readonly ?string $query,
        public readonly ?int $gte,
        public readonly ?int $lte,
        public readonly ?string $category,
        public readonly ?string $shop
    ) {
    }
}
