<?php

namespace App\Infrastructure\Repository;

use App\Controller\Enum\ServiceMessage;
use App\Domain\Service\ConfigService;
use App\Infrastructure\GuzzleHttpClient\GuzzleHttpClient;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client as ESClient;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class ElasticsearchRepository
{
    private ConfigService $config;
    private GuzzleHttpClient $guzzleHttpClient;

    public function __construct()
    {
        $this->config = new ConfigService();
        $this->guzzleHttpClient = new GuzzleHttpClient();
    }

    public function createIndex(string $json): string
    {
        try {
            $this->guzzleHttpClient->createIndex($json);
            $message = ServiceMessage::ElasticCreateSuccess->value;
        } catch (ClientException $e) {
            $message = $e->getMessage();
        }

        return $message;
    }

    public function getIndexInfo(string $json): string
    {
        $response = $this->guzzleHttpClient->getIndexInfo($json);

        return $response ? "\nFound: " . $response->getBody() : ServiceMessage::ElasticIndexNotFound->value;
    }

    public function bulk(string $json): string
    {
        try {
            $response = $this->guzzleHttpClient->bulk($json);
            $message  = ServiceMessage::ElasticBulkSuccess->value;

            if (json_decode($response->getBody(), true)['errors']) {
                $message = ServiceMessage::ElasticBulkError->value;
            }
        } catch (ClientException $e) {
            $message = $e->getMessage();
        }

        return $message;
    }

    public function addRecord(string $json): string
    {
        try {
            $response = $this->guzzleHttpClient->addRecord($json);
            $response = json_decode($response->getBody(), true);
            $string   = "\nResult: index %1s id %2s %3s";
            $message  = sprintf($string, $response['_index'], $response['_id'], $response['result']);
        } catch (ClientException $e) {
            $message  = "\n" . $e->getMessage();
        }

        return $message;
    }

    public function addRecordByPhpClient(string $json): string
    {
        try {
            $response = $this->buildPhpClient()->index(json_decode($json, true));
            $response = $response->asArray();
            $string   = "\nResult: index %1s id %2s %3s";
            $message  = sprintf($string, $response['_index'], $response['_id'], $response['result']);
        } catch (RequestException $e) {
            $message  = $e->getMessage();
        }

        return $message;
    }

    public function getRecord(string $json): string
    {
        try {
            $response = $this->guzzleHttpClient->getRecord($json);
            $body = json_encode(json_decode($response->getBody(), true), JSON_UNESCAPED_UNICODE);
            $message  = "\nFound: " . $body;
        } catch (ClientException $e) {
            $message  = "\n" . $e->getMessage();
        }

        return $message;
    }

    public function getRecordByPhpClient(string $json): string
    {
        try {
            $response = $this->buildPhpClient()->get(json_decode($json, true));
            $body = json_encode($response->asArray()['_source'], JSON_UNESCAPED_UNICODE);
            $message  = "\nFound: " . $body;
        } catch (ClientResponseException $e) {
            $message  = "\n" . $e->getMessage();
        }

        return $message;
    }

    public function search(string $json): string
    {
        try {
            $response = $this->guzzleHttpClient->search($json);
            $hitsQuantity = json_decode($response->getBody(), true)['hits']['total']['value'];
            $hitsList = json_encode(json_decode($response->getBody(), true)['hits']['hits'], JSON_UNESCAPED_UNICODE);
            $string   = "\nFound соответствий: %1d \nList: %2s";
            $message  = sprintf($string, $hitsQuantity, $hitsList);
        } catch (ClientException $e) {
            $message  = "\n" . $e->getMessage();
        }

        return $message;
    }

    public function removeRecord(string $json): string
    {
        try {
            $response = $this->buildPhpClient()->delete(json_decode($json, true));
            $response = $response->asArray();
            $message = "\nId: " . $response['_id'] . ' ' . $response['result'];
        } catch (ClientResponseException $e) {
            $message = "\nError: " . $e->getMessage();
        }

        return  $message;
    }

    public function removeAllRecord(string $json): string
    {
        try {
            $this->guzzleHttpClient->removeAllRecord($json);
            $message = ServiceMessage::ElasticDropSuccess->value;
        } catch (ClientException $e) {
            $message = $e->getMessage();
        }

        if (str_contains($message, '404')) {
            $message = ServiceMessage::ElasticIndexNotFound->value;
        }

        return $message;
    }

    private function buildPhpClient(): ESClient
    {
        return ClientBuilder::create()
            ->setHosts([$this->getUrl()])
            ->setSSLVerification((int)$this->config::get('ELASTICSEARCH_SSL'))
            ->setBasicAuthentication(
                $this->config::get('ELASTICSEARCH_USER'),
                $this->config::get('ELASTICSEARCH_PASSWORD')
            )
            ->build();
    }

    private function getUrl(): string
    {
        return
            $this->config::get('ELASTICSEARCH_SSL') ? 'https://' : 'http://'
            . $this->config::get('ELASTICSEARCH_CONTAINER_NAME')
            . ':'
            . $this->config::get('ELASTICSEARCH_INTERNAL_PORT');
    }
}
