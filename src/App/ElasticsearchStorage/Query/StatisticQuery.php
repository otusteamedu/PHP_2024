<?php

namespace App\ElasticsearchStorage\Query;

class StatisticQuery
{
    public function getLikesAndDislikesByChannel(string $channelId)
    {
        return [
            'index' => (new VideoQuery())->getIndex(),
            'body' => [
                'size' => 0,
                'query' => [
                    'nested' => [
                        'path' => 'channel',
                        'query' => [
                            'bool' => [
                                'must' => [
                                    [
                                        'match' => [
                                            'channel.id' => $channelId
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                'aggs' => [
                    'sum_likes' => [
                        'sum' => [
                            'field' => 'count_likes'
                        ]
                    ],
                    'sum_dislikes' => [
                        'sum' => [
                            'field' => 'count_dislikes'
                        ]
                    ]
                ]
            ],
        ];
    }

    public function prepareLikesAndDislikesByChannel($elasticResponse)
    {
        return [
            'likes' => $elasticResponse['aggregations']['sum_likes']['value'],
            'dislikes' => $elasticResponse['aggregations']['sum_dislikes']['value'],
        ];
    }

    public function getBestChannelsByRatio(int $count = 3)
    {
        return [
            'index' => (new VideoQuery)->getIndex(),
            'body' => [
                'size' => 0,
                'aggs' => [
                    'group_by_channel' => [
                        'terms' => [
                            'field' => 'channel_id'
                        ],
                        'aggs' => [
                            'sum_likes' => [
                                'sum' => [
                                    'field' => 'count_likes'
                                ]
                            ],
                            'sum_dislikes' => [
                                'sum' => [
                                    'field' => 'count_dislikes'
                                ]
                            ],
                            'ratio' => [
                                'bucket_script' => [
                                    'buckets_path' => [
                                        'totalLikes' => 'sum_likes',
                                        'totalDislike' => 'sum_dislikes'
                                    ],
                                    'script' => 'params.totalLikes / params.totalDislike'

                                ],
                            ],
                            'sort_by_ratio' => [
                                'bucket_sort' => [
                                    'sort' => [
                                        [
                                            'ratio' => [
                                                'order' => 'desc'
                                            ]
                                        ]
                                    ],
                                    'size' => $count
                                ]
                            ]
                        ]
                    ],
                ]
            ],
        ];
    }

    public function prepareBestChannelsByRatio($elasticResponse)
    {
        $result = [];

        foreach ($elasticResponse['aggregations']['group_by_channel']['buckets'] as $item) {
            $result[] = [
                'channel_id' => $item['key'],
                'ratio' => $item['ratio']['value'],
                'sum_likes' => $item['sum_likes']['value'],
                'sum_dislikes' => $item['sum_dislikes']['value'],
            ];
        }

        return $result;
    }
}