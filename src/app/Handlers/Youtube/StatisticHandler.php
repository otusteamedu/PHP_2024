<?php

declare(strict_types=1);

namespace App\Handlers\Youtube;

use App\ElasticClient;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class StatisticHandler
{
    const INDEX_NAME = 'video_index';
    private Client $client;

    public function __construct()
    {
        $this->client = (new ElasticClient())->getClient();
    }


    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function getTotalLikesAndDislikes(string $channel_id): array
    {
        $params = [
            'index' => static::INDEX_NAME,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['term' => ['channel_id' => $channel_id]]
                        ]
                    ]
                ],
                'aggs' => [
                    'total_likes' => ['sum' => ['field' => 'likes']],
                    'total_dislikes' => ['sum' => ['field' => 'dislikes']]
                ]
            ]
        ];

        $response = $this->client->search($params);

        return [
            'total_likes' => $response['aggregations']['total_likes']['value'],
            'total_dislikes' => $response['aggregations']['total_dislikes']['value']
        ];
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function getTopChannelsByLikesDislikesRatio(int $size = 10): array
    {
        $params = [
            'index' => static::INDEX_NAME,
            'body' => [
                'size' => 0,
                'aggs' => [
                    'channels' => [
                        'terms' => ['field' => 'channel_id'],
                        'size' => $size,
                        'order' => ['total_ratio' => 'desc']
                    ],
                    'total_ratio' => ['avg' => ['script' => ['source' => '_source.likes / _source.dislikes']]]
                ]
            ]
        ];

        $response = $this->client->search($params);

        return $response['aggregations']['channels']['buckets'];
    }
}
