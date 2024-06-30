<?php

declare(strict_types=1);

namespace Main\Infrastructure;

use Elastic\Elasticsearch\ClientBuilder;

/**
 * Class BookParamsQueryBuilder
 *
 *
 * @property Elastic\Elasticsearch\ClientBuilder $client Название индекса.
 * @property self $instance Массив для хранения параметров запроса.
 */
class ElasticsearchService implements ElasticsearchServiceInterface
{
    protected $client;

    private static $instance;

    /**
     * @inheritDoc
     */
    public function createIndex(string $indexName, $body): bool
    {
        $response = $this->client->indices()->create(['index' => $indexName, 'body' => $body]);
        if ($response['acknowledged']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteIndex(string $indexName): bool
    {
        $params = [
            'index' => $indexName // Замените на имя вашего индекса
        ];

        if ($this->client->indices()->exists($params)) {
            $this->client->indices()->delete($params);
            return true;
        }

        return false;
    }

    /**
     * Закгружает данные из файла
     * @param $filePath
     * @return bool
     */
    public function loadBulkDataFromFile($filePath)
    {
        $data = file_get_contents($filePath);


        $response = $this->client->bulk([
            'body' => $data
        ]);

        if ($response['errors']) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @inheritDoc
     */
    public function search($queryParams): array
    {
        $response = $this->client->search($queryParams);
        return $response->asArray();
    }

    public function getClient(): Elastic\Elasticsearch\ClientBuilder
    {
        $this->client;
    }


    protected function __construct(array $hosts)
    {
        $this->client = Elastic\Elasticsearch\ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }

    protected function __clone()
    {
    }


    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Может существовать только 1 экземпляр приложения");
    }

    /**
     * @return static
     */
    public static function getInstance(array $hosts = []): self
    {
        if (empty(self::$instance)) {
            self::$instance = new static($hosts);
        }

        return self::$instance;
    }
}