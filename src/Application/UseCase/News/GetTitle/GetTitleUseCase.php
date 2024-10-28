<?php

namespace App\Application\UseCase\News\GetTitle;

use App\Application\Gateway\HttpClient\HttpClientGatewayInterface;
use App\Domain\Interface\UseCase\GetTitleUseCaseInterface;
use App\Infrastructure\Gateway\HttpClient\HttpClientGatewayRequest;
use App\Infrastructure\Gateway\HttpClient\HttpClientGatewayResponse;

class GetTitleUseCase implements GetTitleUseCaseInterface
{
    public function __construct(
        private readonly HttpClientGatewayInterface $clientGateway,
    ) {
    }

    public function __invoke(GetTitleUseCaseRequest $request): GetTitleUseCaseResponse
    {
        return new GetTitleUseCaseResponse($request->url, $this->getTitle($request)->title);
    }

    private function getTitle(GetTitleUseCaseRequest $request): HttpClientGatewayResponse
    {
        $httpClientGatewayRequest = new HttpClientGatewayRequest($request->url);

        return ($this->clientGateway)($httpClientGatewayRequest);
    }
}
