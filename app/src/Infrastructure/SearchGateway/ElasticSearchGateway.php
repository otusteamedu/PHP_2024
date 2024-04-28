<?php

declare(strict_types=1);

namespace App\Infrastructure\SearchGateway;

use App\Domain\SearchGateway\SearchGatewayInterface;
use App\Domain\SearchGateway\Request\SearchGatewayRequest;
use App\Domain\SearchGateway\Response\SearchGatewayResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Voiceflow AiGateway.
 */
class ElasticSearchGateway implements SearchGatewayInterface {

  /**
   * Constructor.
   */
  public function __construct(
    private HttpClientInterface $voiceflowClient,
    private SerializerInterface $serializer
  ) {
  }

  /**
   * Interact by text with AiGateway.
   */
  public function search(SearchGatewayRequest $request): SearchGatewayResponse {
    try {
      $result = [];
      return new SearchGatewayResponse(
        $result
      );
    }
    catch (\Throwable $th) {
      throw new \Exception(
        $th->getMessage()
      );
    }
  }

}
