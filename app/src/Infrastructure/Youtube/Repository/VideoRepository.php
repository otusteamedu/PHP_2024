<?php

namespace Valen\App\Infrastructure\Youtube\Repository;

use OpenSearch\Exception\NotFoundHttpException;
use Valen\App\Domain\Youtube\Video;
use Valen\App\Domain\Youtube\VideoRepositoryInterface;
use Valen\App\Infrastructure\OpenSearch\OpenSearchClient;
use Valen\App\Infrastructure\Youtube\Mapper\VideoMapper;

class VideoRepository implements VideoRepositoryInterface
{
    public const string INDEX_NAME = 'youtube_videos';

    public function __construct(
        private readonly OpenSearchClient $client,
        private readonly VideoMapper $videoMapper
    ) {
        $this->createIndexIfNotExists();
    }

    #[\Override]
    public function save(Video $video): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $video->getVideoId(),
            'body' => $this->videoMapper->toStorage($video),
            'refresh' => true // Для немедленного обновления индекса
        ];

        $this->client->client->index($params);
    }

    #[\Override]
    public function delete(string $videoId): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $videoId,
            'refresh' => true,
        ];

        if ($this->client->client->exists($params)) {
            $this->client->client->delete($params);
        }
    }

    #[\Override]
    public function findById(string $videoId): ?Video
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $videoId,
        ];

        try {
            $response = $this->client->client->get($params);
            return $this->videoMapper->toDomain($response['_source']);
        } catch (NotFoundHttpException $e) {
            // Документ не найден
            return null;
        }
    }

    #[\Override]
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

        $response = $this->client->client->search($params);

        $videos = [];
        if (!empty($response['hits']['hits'])) {
            foreach ($response['hits']['hits'] as $hit) {
                $videos[] = $this->videoMapper->toDomain($hit['_source']);
            }
        }

        return $videos;
    }

    private function createIndexIfNotExists(): void
    {
        $params = [
            'index' => self::INDEX_NAME,
        ];

        if (!$this->client->client->indices()->exists($params)) {
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

            $this->client->client->indices()->create($params);
        }
    }
}
