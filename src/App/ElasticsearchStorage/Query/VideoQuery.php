<?php

namespace App\ElasticsearchStorage\Query;

class VideoQuery implements Query
{

    public function getIndex(): string
    {
        return 'videos';
    }

    public function getMapping(): array
    {
        return [
            'index' => $this->getIndex(),
            'body' => [
                'mappings' => [
                    'properties' => [
                        'id' => [
                            'type' => 'keyword',
                        ],
                        'name' => [
                            'type' => 'text',
                        ],
                        'description' => [
                            'type' => 'text',
                        ],
                        'link' => [
                            'type' => 'text',
                        ],
                        'date_created' => [
                            'type' => 'date',
                            'format' => 'YYYY-MM-DD',
                        ],
                        'count_likes' => [
                            'type' => 'integer',
                        ],
                        'count_dislikes' => [
                            'type' => 'integer',
                        ],
                        'count_comments' => [
                            'type' => 'integer',
                        ],
                        'channel_id' => [
                            'type' => 'keyword',
                        ],
                        'channel' => [
                            'type' => 'nested',
                            'properties' => [
                                'id' => [
                                    'type' => 'keyword',
                                ],
                                'name' => [
                                    'type' => 'text',
                                ],
                                'link' => [
                                    'type' => 'text',
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public function createDocQuery(array $data): array
    {
        return [
            'index' => $this->getIndex(),
            'id' => $data['id'],
            'body' => [
                'id' => $data['id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'link' => $data['link'],
                'date_created' => $data['date_created'],
                'count_likes' => $data['count_likes'],
                'count_dislikes' => $data['count_dislikes'],
                'count_comments' => $data['count_comments'],
                'channel_id' => $data['channel_id'],
                'channel' => [
                    'id' => $data['channel']['id'],
                    'name' => $data['channel']['name'],
                    'link' => $data['channel']['link'],
                ],
            ]
        ];
    }
}