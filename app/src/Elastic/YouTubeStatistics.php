<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App\Elastic;

use Elastic\Elasticsearch\Client;

class YouTubeStatistics
{
    private Client $client;

    public function __construct($elastic)
    {
        $this->client = $elastic->client;
    }

    // 1. Суммарное количество лайков и дизлайков для канала
    public function getTotalLikesDislikes($channelId)
    {
        $params = [
            'index' => 'youtube_videos',
            'body' => [
                'query' => [
                    'term' => ['channel_id' => $channelId]
                ],
                'aggs' => [
                    'total_likes' => ['sum' => ['field' => 'like_count']],
                    'total_dislikes' => ['sum' => ['field' => 'dislike_count']]
                ],
                'size' => 0  // Не возвращать сами документы, только агрегации
            ]
        ];

        $response = $this->client->search($params);

        $likes = $response['aggregations']['total_likes']['value'] ?? 0;
        $dislikes = $response['aggregations']['total_dislikes']['value'] ?? 0;

        return [
            'channel_id' => $channelId,
            'total_likes' => $likes,
            'total_dislikes' => $dislikes
        ];
    }

    // 2. Топ N каналов с лучшим соотношением лайков к дизлайкам
    public function getTopChannelsByLikeRatio($topN = 10)
    {
        $params = [
            'index' => 'youtube_videos',
            'body' => [
                'size' => 0,  // Нам нужны только агрегации
                'aggs' => [
                    'channels' => [
                        'terms' => [
                            'field' => 'channel_id',
                            'size' => 1000  // Максимальное количество каналов для анализа
                        ],
                        'aggs' => [
                            'total_likes' => ['sum' => ['field' => 'like_count']],
                            'total_dislikes' => ['sum' => ['field' => 'dislike_count']],
                            'like_ratio' => [
                                'bucket_script' => [
                                    'buckets_path' => [
                                        'likes' => 'total_likes',
                                        'dislikes' => 'total_dislikes'
                                    ],
                                    'script' => "params.dislikes > 0 ? params.likes / params.dislikes : params.likes"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        $channels = [];
        foreach ($response['aggregations']['channels']['buckets'] as $bucket) {
            $channels[] = [
                'channel_id' => $bucket['key'],
                'total_likes' => $bucket['total_likes']['value'],
                'total_dislikes' => $bucket['total_dislikes']['value'],
                'like_ratio' => $bucket['like_ratio']['value']
            ];
        }

        // Сортируем по соотношению лайков к дизлайкам и выбираем топ N
        usort($channels, function ($a, $b) {
            return $b['like_ratio'] <=> $a['like_ratio'];
        });

        return array_slice($channels, 0, $topN);
    }
}
