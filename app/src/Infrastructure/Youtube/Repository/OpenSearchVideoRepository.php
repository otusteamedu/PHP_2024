<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\Youtube\Repository;

use OpenSearch\Client;
use Valen\App\Domain\Youtube\Video;
use Valen\App\Domain\Youtube\VideoRepositoryInterface;
use Valen\App\Infrastructure\Youtube\Mapper\VideoMapper;

final class OpenSearchVideoRepository implements VideoRepositoryInterface
{
    private const string INDEX_NAME = 'youtube_videos';

    public function __construct(
        private readonly Client $client,
        private readonly VideoMapper $videoMapper
    ) {
        $this->createIndexIfNotExists();
    }

    /**
     * Сохраняет видео в OpenSearch
     */
    public function save(Video $video): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $video->videoId,
            'body' => $this->videoMapper->toStorage($video),
            'refresh' => true, // Для немедленного обновления индекса
        ];

        $this->client->index($params);
    }

    /**
     * Удаляет видео из OpenSearch
     */
    public function delete(string $videoId): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $videoId,
            'refresh' => true,
        ];

        if ($this->client->exists($params)) {
            $this->client->delete($params);
        }
    }

    /**
     * Находит видео по его ID
     */
    public function findById(string $videoId): ?Video
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $videoId,
        ];

        try {
            $response = $this->client->get($params);
            if (isset($response['_source'])) {
                return $this->videoMapper->toDomain($response['_source']);
            }
        } catch (\OpenSearch\Common\Exceptions\Missing404Exception) {
            // Документ не найден
        }

        return null;
    }

    /**
     * Находит все видео конкретного канала
     */
    public function findByChannelId(string $channelId): array
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'term' => [
                        'channelId' => $channelId
                    ]
                ],
                'size' => 1000, // Лимит результатов
                'sort' => [
                    'publishedAt' => [
                        'order' => 'desc'
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        $videos = [];
        if (isset($response['hits']['hits']) && !empty($response['hits']['hits'])) {
            foreach ($response['hits']['hits'] as $hit) {
                $videos[] = $this->videoMapper->toDomain($hit['_source']);
            }
        }

        return $videos;
    }

    /**
     * Создает индекс в OpenSearch, если он еще не существует
     */
    public function createIndexIfNotExists(): void
    {
        $params = [
            'index' => self::INDEX_NAME,
        ];

        if (!$this->client->indices()->exists($params)) {
            $params['body'] = [
                'mappings' => [
                    'properties' => [
                        'videoId' => ['type' => 'keyword'],
                        'channelId' => ['type' => 'keyword'],
                        'title' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'publishedAt' => ['type' => 'date'],
                        'viewCount' => ['type' => 'integer'],
                        'likeCount' => ['type' => 'integer'],
                        'dislikeCount' => ['type' => 'integer'],
                        'commentCount' => ['type' => 'integer'],
                    ],
                ],
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1,
                ],
            ];

            $this->client->indices()->create($params);
        }
    }
}