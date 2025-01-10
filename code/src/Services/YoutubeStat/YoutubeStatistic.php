<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw10\Services\YoutubeStat;

use Asyrovatkin\Hw10\Classes\Elastic;

class YoutubeStatistic
{
    const INDEX_NAME = 'y-stat';
    private Elastic $elastic;

    public function __construct()
    {
        $this->elastic = new Elastic(self::INDEX_NAME);
    }

    public function getTop($topNum): void
    {
        $topNum = $topNum ? intval($topNum) : 10;

        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                "size" => 0,
                "aggs" => [
                    "by_channel_title" => [
                        "terms" => [
                            "field" => "channel_title",
                            "size" => 100000
                        ],
                        "aggs" => [
                            "ratio" => [
                                "scripted_metric" => [
                                    "init_script" => "state.likes_sum = 0;state.dislikes_sum = 0;",
                                    "map_script" => "state.likes_sum += doc.likes.value;state.dislikes_sum += doc.dislikes.value;",
                                    "combine_script" => "return state",
                                    "reduce_script" => "double likes_total = 0;double dislikes_total = 0; for (s in states) {likes_total += s.likes_sum; dislikes_total += s.dislikes_sum} return (likes_total/dislikes_total);"
                                ]
                            ],
                            "sort_by_ratio" => [
                                "bucket_sort" => [
                                    "sort" => [
                                        [
                                            "ratio.value" => [
                                                "order" => "desc"
                                            ]
                                        ]
                                    ],
                                    "size" => $topNum
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $result = $this->elastic->search($params)->asObject();

        print 'Ratio top ' . $topNum . " (можно изменить добавив в uri к-во например /top/20) <br>";

        foreach ($result->aggregations->by_channel_title->buckets as $bucket) {
            print 'Chanel: ' . $bucket->key . ' Ratio: ' . $bucket->ratio->value . "<br>";
        }

    }

    public function getSummary($channelTitle): void
    {
        if (!$channelTitle) {
            print 'Нужно добавить в uri название канала, например /summary/Chanelhig';
            return;
        }

        $params = [
            'size' => 0,
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'match' => [
                        'channel_title' => [
                            'query' => $channelTitle
                        ]
                    ]
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
                ]
            ]
        ];

        $result = $this->elastic->search($params)->asObject();

        if ($result->hits->total->value === 0) {
            print 'Nothing found';
        } else {
            print 'Channel: ' . $channelTitle . "<br>";
            print 'Total likes: ' . $result->aggregations->total_likes->value . "<br>";
            print 'Total dislikes: ' . $result->aggregations->total_dislikes->value . "<br>";
            print 'Ratio: ' . $result->aggregations->total_likes->value / $result->aggregations->total_dislikes->value;
        }
    }
}