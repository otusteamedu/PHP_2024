<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App\Elastic;

use Elastic\Elasticsearch\Client;

class DataHandler
{
    private Client $client;

    public function __construct($elastic)
    {
        $this->client = $elastic->client;
    }

    // Добавление канала
    public function addChannel($data)
    {
        $params = [
            'index' => 'youtube_channels',
            'id'    => $data['channel_id'],
            'body'  => $data
        ];

        $response = $this->client->index($params);
        return $response;
    }

    // Удаление канала
    public function deleteChannel($channel_id)
    {
        $params = [
            'index' => 'youtube_channels',
            'id'    => $channel_id
        ];

        $response = $this->client->delete($params);
        return $response;
    }

    // Добавление видео
    public function addVideo($data)
    {
        $params = [
            'index' => 'youtube_videos',
            'id'    => $data['video_id'],
            'body'  => $data
        ];

        $response = $this->client->index($params);
        return $response;
    }

    // Удаление видео
    public function deleteVideo($video_id)
    {
        $params = [
            'index' => 'youtube_videos',
            'id'    => $video_id
        ];

        $response = $this->client->delete($params);
        return $response;
    }

    // Метод для получения всех документов из индекса
    public function getAllDocuments($indexName)
    {
        $params = [
            'index' => $indexName,
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()  // Запрос match_all возвращает все документы
                ],
                'size' => 100
            ]
        ];

        $response = $this->client->search($params);
        return $response['hits']['hits'];  // Возвращаем массив документов
    }
}
