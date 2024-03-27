<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Repository;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Rmulyukov\Hw11\Application\Dto\ItemsDto;
use Rmulyukov\Hw11\Application\Repository\ShopCommandRepositoryInterface;

final readonly class ShopCommandElasticRepository implements ShopCommandRepositoryInterface
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(
        private string $host
    ) {
        $this->client = ClientBuilder::create()->setHosts([$this->host])->build();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function initStorage(string $storageName, array $settings): array
    {
        return $this->client->indices()->create([
            'index' => $storageName,
            'body' => $settings
        ])->asArray();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function addItems(string $storageName, ItemsDto $items): array
    {
        return $this->client->bulk([
            'index' => $storageName,
            'body' => $items->getItems()
        ])->asArray();
    }
}
