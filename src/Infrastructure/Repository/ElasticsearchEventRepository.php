<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Event;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\EventRepositoryInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\ClientInterface;

class ElasticsearchEventRepository implements EventRepositoryInterface
{
    private ClientInterface $client;
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([$_ENV['ES_HOST'] . ':' . $_ENV['ES_PORT']])
            ->build();
    }

    /**
     * @inheritDoc
     */
    public function save(Event $event): void
    {
        $condition = [];
        foreach ($event->getCondition() as $param => $value) {
            $condition[] = ['param' => $param, 'value' => $value];
        }

        $this->client->index([
            'index' => 'events',
            'body' => [
                'event' => $event->getEvent(),
                'priority' => $event->getPriority(),
                'condition' => $condition
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function deleteAll(): void
    {
        $this->client->deleteByQuery(
            [
                'index' => 'events',
                'body' => [
                    'query' => ['match_all' => new \stdClass()]
                ]
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function matchByCondition(array $condition): ?Event
    {
        $compareCondition = $condition;
        ksort($compareCondition);
        $compareString = '';
        foreach ($compareCondition as $key => $value) {
            $compareString .= "{$key}:{$value};";
        }

        $shouldConditions = [];
        foreach ($condition as $param => $value) {
            $shouldConditions[] = ['match' => ['condition.param' => $param]];
            $shouldConditions[] = ['match' => ['condition.value' => $value]];
        }
        $sizeChunk = 1000;
        $response = $this->client->search(
            [
                'index' => 'events',
                'body' => [
                    'query' => [
                        'nested' => [
                            'path' => 'condition',
                            'query' => [
                                'bool' => ['should' => $shouldConditions],
                            ]
                        ],
                    ],
                    'sort' => [
                        ['priority' => 'desc'],
                    ],
                    'size' => $sizeChunk
                ],
                'scroll' => '1m'
            ],
        );

        $result = $response->asArray();
        $rows = $result['hits']['hits'] ?? [];
        $total = $result['hits']['total'] ?? 0;
        while ($rows) {
            foreach ($rows as $row) {
                $item = $row['_source'];
                $conditions = array_reduce(
                    $item['condition'] ?? [],
                    static function (array $map, array $item): array {
                        $map[$item['param']] = $item['value'];
                        return $map;
                    },
                    []
                );

                ksort($conditions);
                $resultString = '';
                foreach ($condition as $param => $value) {
                    $resultString .= "{$param}:{$value};";
                }

                if (
                    (mb_strpos($resultString, $compareString) !== false)
                    || (mb_strpos($compareString, $resultString) !== false)
                ) {
                    return new Event((string) $item['event'], (int) $item['priority'], (array) $item['condition']);
                }
            }

            if (($total < $sizeChunk) || (count($rows) < $sizeChunk)) {
                break;
            }

            $response = $this->client->scroll(
                [
                    'scroll' => '1m',
                    'scroll_id' => $response->asArray()['_scroll_id']
                ],
            );

            $rows = $response->asArray()['hits']['hits'] ?? [];
        }

        throw new NotFoundException('Could not match events');
    }
}
