<?php

declare(strict_types=1);

namespace App\Domain\SearchGateway;

use App\Domain\SearchGateway\Request\SearchGatewayRequest;
use App\Domain\SearchGateway\Response\SearchGatewayResponse;

/**
 * Interface for search gateway.
 */
interface SearchGatewayInterface
{
    /**
     * Interact by text with AiGateway.
     */
    public function search(SearchGatewayRequest $request): SearchGatewayResponse;
}
