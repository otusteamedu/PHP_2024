<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App\Elastic;

use Elastic\Elasticsearch\Client;

class IndexHandler
{
    private Client $client;
    private $index_type;
    private $params;

    public function __construct($elastic, $index_type)
    {
        $this->client = $elastic->client;
        $this->index_type = $index_type;
    }

    public function createIndex(): void
    {
        try {
            switch ($this->index_type) {
                case 'channels_index':
                    $this->params = [
                        'index' => 'youtube_channels',
                        'body' => [
                            'mappings' => [
                                'properties' => [
                                    'channel_id' => ['type' => 'keyword'],
                                    'channel_name' => ['type' => 'text'],
                                    'description' => ['type' => 'text'],
                                    'creation_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd'],
                                    'subscriber_count' => ['type' => 'integer'],
                                    'total_videos' => ['type' => 'integer'],
                                    'total_views' => ['type' => 'long'],
                                    'country' => ['type' => 'keyword'],
                                    'tags' => ['type' => 'text']
                                ]
                            ]
                        ]
                    ];
                    break;
                case 'videos_index':
                    $this->params = [
                        'index' => 'youtube_videos',
                        'body' => [
                            'mappings' => [
                                'properties' => [
                                    'video_id' => ['type' => 'keyword'],
                                    'channel_id' => ['type' => 'keyword'],
                                    'video_title' => ['type' => 'text'],
                                    'description' => ['type' => 'text'],
                                    'publish_date' => ['type' => 'date', 'format' => 'yyyy-MM-dd'],
                                    'view_count' => ['type' => 'long'],
                                    'like_count' => ['type' => 'integer'],
                                    'dislike_count' => ['type' => 'integer'],
                                    'comment_count' => ['type' => 'integer'],
                                    'duration_seconds' => ['type' => 'integer'],
                                    'tags' => ['type' => 'text'],
                                    'category' => ['type' => 'keyword']
                                ]
                            ]
                        ]
                    ];

                default:
                    break;
            }

            $response = $this->client->indices()->create($this->params);
            echo $response;
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            echo "ERROR (index creating): $th";
        }
    }

    public function deleteIndex(): void
    {

        try {
            switch ($this->index_type) {
                case 'channels_index':
                    echo $this->index_type;
                    $response = $this->client->indices()->delete(['index' => 'youtube_channels']);
                    echo $response;
                    break;
                case 'videos_index':
                    $response = $this->client->indices()->delete(['index' => 'youtube_videos']);
                    echo $response;
                    break;
                default:
                    break;
            }
        } catch (\Throwable $th) {
            echo "ERROR (index deleting): $th";
        }
    }
}
