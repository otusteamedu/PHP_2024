<?php

namespace App\Services;

use App\Models\Video;
use Elastic\Elasticsearch\Client;

class YouTubeService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getTotalLikesDislikes($channelId): array
    {
        $response = $this->client->search([
            'index' => 'youtube_channels',
            'body' => [
                'query' => [
                    'match' => ['channel_id' => $channelId]
                ]
            ]
        ]);

        $likes = 0;
        $dislikes = 0;

        if (isset($response['hits']['hits'])) {
            foreach ($response['hits']['hits'] as $hit) {
                $likes += $hit['_source']['likes'];
                $dislikes += $hit['_source']['dislikes'];
            }
        }

        return ['likes' => $likes, 'dislikes' => $dislikes];
    }

    public function getTopChannelsByLikesDislikesRatio($topN)
    {
        $response = $this->client->search([
            'index' => 'youtube_channels',
            'body' => [
                'size' => 0,
                'aggs' => [
                    'channels' => [
                        'terms' => [
                            'field' => 'channel_id',
                            'size' => $topN,
                        ],
                        'aggs' => [
                            'total_likes' => [
                                'sum' => [
                                    'field' => 'likes'
                                ]
                            ],
                            'total_dislikes' => [
                                'sum' => [
                                    'field' => 'dislikes'
                                ]
                            ],
                            'likes_dislikes_ratio' => [
                                'bucket_script' => [
                                    'buckets_path' => [
                                        'likes' => 'total_likes',
                                        'dislikes' => 'total_dislikes'
                                    ],
                                    'script' => 'params.likes / (params.dislikes + 1)'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        return $response['aggregations']['channels']['buckets'];
    }
}
