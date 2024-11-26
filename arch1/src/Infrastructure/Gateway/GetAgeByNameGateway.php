<?php

namespace App\Infrastructure\Gateway;

use App\Domain\Gateway\RequestAgeByNameGatewayInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAgeByNameGateway implements RequestAgeByNameGatewayInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private HttpClientInterface $httpClient,
    ) {
        //
    }

    public function requestAge(string $name): ?int
    {
        $response = $this->httpClient->request('GET', $this->parameterBag->get('app.age-by-name.host'), [
            'query' => [
                'name' => $name,
            ]
        ]);

        $age = $response->toArray()['age'] ?? null;

        return is_int($age) ? $age : null;
    }
}
