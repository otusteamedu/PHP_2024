<?php

declare(strict_types=1);

namespace App\Handlers\Youtube;

use App\Dto\VideoDTO;
use App\ElasticClient;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

class VideoHandler
{
    const INDEX_NAME = 'video_index';

    private Client $client;

    public function __construct()
    {
        $this->client = (new ElasticClient())->getClient();
    }


    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function addVideo(VideoDTO $video): Elasticsearch|\Http\Promise\Promise
    {
        $params = [
            'index' => static::INDEX_NAME,
            'id' => $video->getId(),
            'body' => [
                'title' => $video->getTitle(),
                'description' => $video->getDescription(),
                'likes' => $video->getLikes(),
                'dislikes' => $video->getDislikes(),
                'channel_id' => $video->getChannelId(),
            ],
        ];

        return $this->client->index($params);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function deleteVideo($video_id): Elasticsearch|\Http\Promise\Promise
    {
        $params = [
            'index' => static::INDEX_NAME,
            'id' => $video_id
        ];

        return $this->client->delete($params);
    }
}
