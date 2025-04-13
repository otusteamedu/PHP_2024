<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\Youtube\Repository;

use OpenSearch\Exception\NotFoundHttpException;
use Valen\App\Domain\Youtube\Channel;
use Valen\App\Domain\Youtube\ChannelRepositoryInterface;
use Valen\App\Infrastructure\OpenSearch\OpenSearchClient;
use Valen\App\Infrastructure\Youtube\Mapper\ChannelMapper;

class ChannelRepository implements ChannelRepositoryInterface
{
    public const STRING INDEX_NAME = 'youtube_channels';

    public function __construct(
        private readonly OpenSearchClient $client,
        private readonly ChannelMapper $channelMapper
    ) {
        $this->createIndexIfNotExists();
    }

    #[\Override]
    public function save(Channel $channel): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $channel->getChannelId(),
            'body' => $this->channelMapper->toStorage($channel),
            'refresh' => true // Для немедленного обновления индекса
        ];

        $this->client->client->index($params);
    }

    #[\Override]
    public function delete(string $channelId): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $channelId,
            'refresh' => true,
        ];

        // Проверяем, существует ли документ, прежде чем пытаться удалить его
        if ($this->client->client->exists($params)) {
            $this->client->client->delete($params);
        }
    }
    #[\Override]
    public function findById(string $channelId): ?Channel
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $channelId,
        ];

        try {
            $response = $this->client->client->get($params);
            return $this->channelMapper->toDomain($response['_source']);
        } catch (NotFoundHttpException $e) {
            // Документ не найден
            return null;
        }
    }

    #[\Override]
    public function findAll(int $limit = 100, int $offset = 0): array
    {
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
                        'channelId' => ['type' => 'keyword'],
                        'title' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'description' => ['type' => 'text'],
                        'subscriberCount' => ['type' => 'integer'],
                        'videoCount' => ['type' => 'integer'],
                        'publishedAt' => ['type' => 'date'],
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
