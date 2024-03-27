<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Elk\ElkService;
use DI\Container;
use Dotenv\Dotenv;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ElasticsearchException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function DI\create;
use function DI\get;

final class App
{
    private const INDEX_NAME = 'otus-shop';
    private const INDEX_ALIAS = 'books';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws AuthenticationException
     */
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $container = $this->resolveDI();
        $client = $container->get(Client::class);
        $health = $client->cluster()->health();
        echo $health->asArray()['status'] . PHP_EOL;
        $elkSearch = $container->get(ElkService::class)->createIndex();
        try {
            $this->initIndex($elkSearch);
        } catch (ElasticsearchException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        /*
         * ToDO:
         *  1) Разобраться с анализаторами и токенизаторами для русского языка
         *  2) Загрузить файл с каталогом книг с помощью _bulk
        */
    }

    /**
     * @throws AuthenticationException
     */
    private function resolveDI(): ContainerInterface
    {
        $host = $_ENV['ELASTICSEARCH_HOST'];
        $port = $_ENV['ELASTICSEARCH_PORT'];

        return new Container([
            Client::class => ClientBuilder::create()
                ->setHosts(["http://$host:$port"])
                ->build(),
            ElkService::class => create()->constructor(
                get(Client::class)
            ),
        ]);
    }

    /**
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    private function initIndex(Client $client): void
    {
        if ($client->indices()->exists(['index' => self::INDEX_NAME])) {
            return;
        }

        $params = [
            'index' => self::INDEX_NAME,
            'alias' => self::INDEX_ALIAS,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                    'analysis' => [
                        'analyzer' => [
                            'default' => [
                                'type' => 'russian',
                            ],
                        ],
                    ],
                ],
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'russian',
                        ],
                        'sku' => [
                            'type' => 'keyword',
                        ],
                        'category' => [
                            'type' => 'keyword',
                            'analyzer' => 'russian',
                        ],
                        'price' => [
                            'type' => 'integer',
                        ],
                        'stock' => [
                            'type' => 'nested',
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword',
                                    'analyzer' => 'russian',
                                ],
                                'stock' => [
                                    'type' => 'integer',
                                ]
                            ]
                        ],
                    ]
                ]
            ],
        ];
        $client->indices()->create($params);
    }
}
