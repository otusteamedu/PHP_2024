<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\YoutubeAnalyze\Repository;

use DateMalformedStringException;
use OpenSearch\Client;
use Valen\App\Domain\YoutubeAnalyze\Channel;
use Valen\App\Domain\YoutubeAnalyze\ChannelRepositoryInterface;
use Valen\App\Infrastructure\YoutubeAnalyze\Mapper\ChannelMapper;

final class OpenSearchChannelRepository implements ChannelRepositoryInterface
{
    private const string INDEX_NAME = 'youtube_channels';

    public function __construct(
        private readonly Client $client,
        private readonly ChannelMapper $channelMapper
    ) {
    }

    /**
     * Сохраняет канал в OpenSearch
     */
    public function save(Channel $channel): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $channel->channelId,
            'body' => $this->channelMapper->toStorage($channel),
            'refresh' => true, // Для немедленного обновления индекса
        ];

        $this->client->index($params);
    }

    /**
     * Удаляет канал из OpenSearch
     */
    public function delete(string $channelId): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $channelId,
            'refresh' => true,
        ];

        // Проверяем, существует ли документ, прежде чем пытаться удалить его
        if ($this->client->exists($params)) {
            $this->client->delete($params);
        }
    }

    /**
     * Находит канал по его ID
     */
    public function findById(string $channelId): ?Channel
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id' => $channelId,
        ];

        try {
            $response = $this->client->get($params);
            if (isset($response['_source'])) {
                return $this->channelMapper->toDomain($response['_source']);
            }
        } catch (DateMalformedStringException $e) {
            // Документ не найден
        }

        return null;
    }

    /**
     * Возвращает список всех каналов с пагинацией
     * @throws DateMalformedStringException
     */
    public function findAll(int $limit = 100, int $offset = 0): array
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'match_all' => (object)[],
                ],
                'from' => $offset,
                'size' => $limit,
                'sort' => [
                    'publishedAt' => [
                        'order' => 'desc',
                    ],
                ],
            ],
        ];

        $response = $this->client->search($params);

        $channels = [];
        if (!empty($response['hits']['hits'])) {
            foreach ($response['hits']['hits'] as $hit) {
                $channels[] = $this->channelMapper->toDomain($hit['_source']);
            }
        }

        return $channels;
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

            $this->client->indices()->create($params);
        }
    }
}
