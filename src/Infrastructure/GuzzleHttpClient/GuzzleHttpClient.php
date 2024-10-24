<?php

namespace App\Infrastructure\GuzzleHttpClient;

use App\Domain\Service\ConfigService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient
{
    private ConfigService $config;

    private Client $httpClient;

    public function __construct()
    {
        $this->config = new ConfigService();
        $this->httpClient = new Client();
    }

    public function createIndex(string $json): ResponseInterface
    {
        return $this->httpClient->put(
            $this->getUrl() . '/' . $this->jsonToArray($json)['index'],
            [
                'verify' => $this->isSslVerification(),
                RequestOptions::AUTH => $this->getCredentials(),
                'headers' => ['Content-Type' => 'application/json'],
                'body' => fopen($this->config::get('ELASTICSEARCH_RU_SETTINGS'), 'r'),
            ]
        );
    }

    public function getIndexInfo(string $json): ?ResponseInterface
    {
        try {
            $response = $this->httpClient->get(
                $this->getUrl() . '/' . $this->jsonToArray($json)['index'],
                [
                    'verify' => $this->isSslVerification(),
                    RequestOptions::AUTH => $this->getCredentials(),
                ]
            );
        } catch (ClientException $e) {
            $message = $e->getMessage();
        }

        return $message ? null : $response;
    }

    public function bulk(string $json): ResponseInterface
    {
        $file = $this->getImportFilePath($this->jsonToArray($json)['fileName']);
        $index = (json_decode(file($file)[0], true)['create'])['_index'];
        $checkIndex = json_encode(['index' => $index]);

        if (!$this->getIndexInfo($checkIndex)) {
            $this->createIndex($checkIndex);
        }

        return $this->httpClient->post(
            $this->getUrl() . '/_bulk',
            [
                'verify' => $this->isSslVerification(),
                RequestOptions::AUTH => $this->getCredentials(),
                'headers' => ['Content-Type' => 'application/json'],
                'body' => fopen($file, 'r'),

            ]
        );
    }

    public function addRecord(string $json): ResponseInterface
    {
        $string = "%1s/%2s/_doc/%3s";
        $index  = $this->jsonToArray($json)['index'];
        $idDoc  = $this->jsonToArray($json)['id'];

        return $this->httpClient->put(
            sprintf($string, $this->getUrl(), $index, $idDoc),
            [
                'verify' => $this->isSslVerification(),
                RequestOptions::AUTH => $this->getCredentials(),
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($this->jsonToArray($json)['body']),
            ]
        );
    }

    public function getRecord(string $json): ResponseInterface
    {
        $string = "%1s/%2s/_doc/%3s";
        $index  = $this->jsonToArray($json)['index'];
        $idDoc  = $this->jsonToArray($json)['id'];

        return $this->httpClient->get(
            sprintf($string, $this->getUrl(), $index, $idDoc),
            [
                'verify' => $this->isSslVerification(),
                RequestOptions::AUTH => $this->getCredentials(),
            ]
        );
    }

    public function search(string $json): ResponseInterface
    {
        return $this->httpClient->get(
            $this->getUrl() . '/' . $this->jsonToArray($json)['index'] . '/_search',
            [
                'verify' => $this->isSslVerification(),
                RequestOptions::AUTH => $this->getCredentials(),
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($this->jsonToArray($json)['body']),
            ]
        );
    }

    public function removeAllRecord(string $json): void
    {
        $this->httpClient->delete(
            $this->getUrl() . '/' .  $this->jsonToArray($json)['index'],
            [
                'verify' => $this->isSslVerification(),
                RequestOptions::AUTH => $this->getCredentials(),
            ]
        );
    }

    private function jsonToArray(string $json): array
    {
        return json_decode($json, true);
    }

    private function getUrl(): string
    {
        return
            $this->config::get('ELASTICSEARCH_SSL') ? 'https://' : 'http://'
                . $this->config::get('ELASTICSEARCH_CONTAINER_NAME')
                . ':'
                . $this->config::get('ELASTICSEARCH_INTERNAL_PORT');
    }

    private function isSslVerification(): bool
    {
        return (bool)$this->config::get('ELASTICSEARCH_SSL');
    }

    private function getCredentials(): array
    {
        return [
            $this->config::get('ELASTICSEARCH_USER'),
            $this->config::get('ELASTICSEARCH_PASSWORD')
        ];
    }

    private function getImportFilePath(string $importFileName)
    {
        return
            $this->config::get('ELASTICSEARCH_IMPORT_DIR')
            . $importFileName . '.'
            . $this->config::get('ELASTICSEARCH_IMPORT_FILE_TYPE');
    }
}
