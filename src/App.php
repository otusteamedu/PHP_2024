<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Elk\ElkRepository;
use Alogachev\Homework\Elk\ElkService;
use Alogachev\Homework\Exception\TestIndexDataNotFoundException;
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
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws AuthenticationException
     */
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $testDataPath = $_ENV['ELASTICSEARCH_DATA_PATH'] ?? null;
        if (is_null($testDataPath)) {
            throw new TestIndexDataNotFoundException();
        }

        $container = $this->resolveDI();
        try {
            /** @var ElkService $elkService */
            $elkService = $container->get(ElkService::class);
            $health = $elkService->getClusterHealthCheckArray();
            echo $health['status'] . PHP_EOL;
            $this->initIndex($elkService, $testDataPath);
            $this->search($elkService);
        } catch (ElasticsearchException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }

        /*
         * ToDO:
         *  1) Разобраться с анализаторами и токенизаторами для русского языка
         *  2) Разработать модели для поиска, добавить фильтры по категории,
         *   ранжированные по цене, сортированные по остаткам в магазине.
         *  3) Сделать обработку аргументов для консольной команды поиска
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
                get(ElkRepository::class)
            ),
            ElkRepository::class => create()->constructor(
                get(Client::class)
            ),
        ]);
    }

    /**
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    private function initIndex(ElkService $elkService, string $testDataPath): void
    {
        $fullPath = dirname(__DIR__) . '/' . $testDataPath;
        $elkService->createAndFillBooksIndex($fullPath);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    private function search(ElkService $elkService): void
    {
        $elkService->search();
    }
}
