<?php

declare(strict_types=1);

namespace App\Handlers\Youtube;

use App\Dto\ChannelDTO;
use App\ElasticClient;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

class ChannelHandler
{
    const INDEX_NAME = 'channel_index';

    private Client $client;

    public function __construct()
    {
        $this->client = (new ElasticClient())->getClient();
    }


    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function addChannel(ChannelDTO $channel): Elasticsearch|\Http\Promise\Promise
    {
        $params = [
            'index' => static::INDEX_NAME,
            'id' => $channel->getId(),
            'body' => [
                'name' => $channel->getName(),
                'description' => $channel->getDescription(),
            ],
        ];

        return $this->client->index($params);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function deleteChannel(string $channel_id): Elasticsearch|\Http\Promise\Promise
    {
        $params = [
            'index' => static::INDEX_NAME,
            'id' => $channel_id
        ];

        return $this->client->delete($params);
    }
}
