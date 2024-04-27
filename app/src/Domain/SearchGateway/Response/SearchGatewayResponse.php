<?php

declare(strict_types=1);

namespace App\Domain\SearchGateway\Response;

/**
 * Response class.
 */
class SearchGatewayResponse {

  /**
   * Construct Response.
   */
  public function __construct(
    public readonly array $traces,
    public readonly string $answer
  ) {
  }

}
