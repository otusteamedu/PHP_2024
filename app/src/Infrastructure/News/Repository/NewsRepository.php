<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\News\Repository;

use Valen\App\Domain\News\Entity\News;
use Valen\App\Domain\News\Repository\NewsRepositoryInterface;
use Valen\App\Infrastructure\News\Mapper\NewsMapper;
use Valen\App\Infrastructure\OpenSearch\OpenSearchClient;

class NewsRepository implements NewsRepositoryInterface
{
    public const string INDEX_NAME = 'news';

    public function __construct(
        private readonly OpenSearchClient $client,
        private readonly NewsMapper $newsMapper
    ) {
        $this->createIndexIfNotExists();
    }

    public function save(News $news): void
    {
        // TODO: Implement save() method.
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $video->getVideoId(),
            'body' => $this->videoMapper->toStorage($video),
            'refresh' => true // Для немедленного обновления индекса
        ];

        $this->client->client->index($params);
    }

    public function delete(int $newsId): void
    {
        // TODO: Implement delete() method.
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $videoId,
            'refresh' => true,
        ];

        if ($this->client->client->exists($params)) {
            $this->client->client->delete($params);
        }
    }

    public function findById(int $newsId): ?News
    {
        // TODO: Implement findById() method.
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

    public function findAll(int $limit = 100, int $offset = 0): array
    {
        // TODO: Implement findAll() method.
        try {
            $response = $this->client->client->search([
                'index' => self::INDEX_NAME,
                'body' => [
                    'query' => [
                        'match_all' => new \stdClass()
                    ],
                    'size' => 10000 // Ограничение на максимальное количество каналов
                ]
            ]);

            $channels = [];
            foreach ($response['hits']['hits'] as $hit) {
                $channels[] = $this->channelMapper->toDomain($hit['_source']);
            }

            return $channels;
        } catch (\Exception $e) {
            // Ничего не найдено
            return [];
        }
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
