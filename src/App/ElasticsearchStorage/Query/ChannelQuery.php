<?php

namespace App\ElasticsearchStorage\Query;

class ChannelQuery implements Query
{

    public function getIndex(): string
    {
        return 'channels';
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
                        'count_videos' => [
                            'type' => 'integer',
                        ],
                        'count_subscribers' => [
                            'type' => 'integer',
                        ],
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
                'count_videos' => $data['count_videos'],
                'count_subscribers' => $data['count_subscribers'],
            ]
        ];
    }
}