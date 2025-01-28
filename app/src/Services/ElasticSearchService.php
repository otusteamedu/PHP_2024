<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusElasticsearchApp\Services;

use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;
use Http\Promise\Promise;
use Exception;

class ElasticSearchService
{
    private Client $client;

    private string $index = 'otus-shop';

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->setClient();
    }

    /**
     * Метод устанавливает соединение с Elasticsearch
     *
     * @throws AuthenticationException
     */
    public function connection(): Client
    {
        return ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->setSSLVerification(false)
            ->build();
    }

    /**
     * Метод возвращает клиента
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Метод устанавливает клиента
     *
     * @return void
     * @throws Exception
     * @throws AuthenticationException
     */
    public function setClient(): void
    {
        try {
            $this->client = $this->connection();
        } catch (Exception $e) {
            throw new Exception("Ошибка при подключении к ElasticSearch: " . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Метод проверяет существует ли индекс
     *
     * @return bool
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    private function isExistsIndex(): bool
    {
        return $this->client->indices()->exists([
            'index' => $this->index,
        ])->asBool();
    }

    /**
     * Метод для выполнения поиска
     *
     * @throws Exception
     */
    public function search(string $data): Elasticsearch|Promise
    {
        $query = json_decode($data, true);

        if (empty($query)) {
            throw new Exception("Данные для поиска пусты!" . PHP_EOL);
        }

        $params = [
            'index' => $this->index,
            'body' => $query,
        ];

        try {
            return $this->client->search($params);
        } catch (Exception $e) {
            throw new Exception("Ошибка при поиске: " . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Метод возвращает документ из индекса
     * по идентификатору
     *
     * @param string $id
     *
     * @return Elasticsearch|Promise
     * @throws Exception
     */
    public function getDocumentById(string $id): Elasticsearch|Promise
    {
        $params = [
            'index' => $this->index,
            'id' => $id
        ];

        try {
            return $this->client->get($params);
        } catch (Exception $e) {
            throw new Exception("Ошибка при получении документа: " . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Метод удаляет документ из индекса
     * по идентификатору
     *
     * @param string $id
     *
     * @return Elasticsearch|Promise
     * @throws Exception
     */
    public function deleteDocumentById(string $id): Elasticsearch|Promise
    {
        $params = [
            'index' => $this->index,
            'id' => $id
        ];

        try {
            return $this->client->delete($params);
        } catch (Exception $e) {
            throw new Exception("Ошибка при удалении документа: " . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Метод обновляет документ из индекса
     * по идентификатору
     *
     * @param string $id
     * @param string $data
     *
     * @return Elasticsearch|Promise
     * @throws Exception
     */
    public function updateDocumentById(string $id, string $data): Elasticsearch|Promise
    {
        $update = json_decode($data, true);

        if (empty($update)) {
            throw new Exception("Данные для обновления пусты!" . PHP_EOL);
        }

        $params = [
            'index' => $this->index,
            'id' => $id,
            'body' => [
                'doc' => $update
            ]
        ];

        try {
            return $this->client->update($params);
        } catch (Exception $e) {
            throw new Exception("Ошибка при обновлении документа: " . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Метод добавляет индекс
     *
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     * @throws Exception
     */
    public function createIndex(): Elasticsearch|Promise
    {
        $params = [
            'index' => $this->index
        ];

        if ($this->isExistsIndex()) {
            throw new Exception("Такой индекс уже существует!" . PHP_EOL);
        }

        try {
            return $this->client->indices()->create($params);
        } catch (Exception $e) {
            throw new Exception("Ошибка при создании индекса: " . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Метод берет json и вызывает метод bulk
     * для массового создания документов
     *
     * @throws Exception
     */
    public function bulkDocumentCreate(string $filepath): Elasticsearch|Promise
    {
        if (!file_exists($filepath)) {
            throw new Exception('Такого файла не существует!' . PHP_EOL);
        }

        $resultData = [];
        $data = explode(PHP_EOL, file_get_contents($filepath));

        foreach ($data as $item) {
            $item = json_decode($item, true);

            if (!empty($item)) {
                $resultData[] = $item;
            }
        }

        return $this->bulk($resultData);
    }

    /**
     * Метод удаляет индекс
     *
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     * @throws Exception
     */
    public function deleteIndex(): Elasticsearch|Promise
    {
        $params = [
            'index' => $this->index,
        ];

        if (!$this->isExistsIndex()) {
            throw new Exception("Такого индекса не существует!" . PHP_EOL);
        }

        try {
            return $this->client->indices()->delete($params);
        } catch (Exception $e) {
            throw new Exception("Ошибка при удалении индекса: " . $e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Метод для массового создания документов
     *
     * @param array $body
     *
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws Exception
     */
    private function bulk(array $body): Elasticsearch|Promise
    {
        $params = [
            'body' => $body,
        ];

        try {
            return $this->client->bulk($params);
        } catch (Exception $e) {
            throw new Exception("Ошибка при массовом добавлении документов: " . $e->getMessage() . PHP_EOL);
        }
    }

}