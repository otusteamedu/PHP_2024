<?php

declare(strict_types=1);

namespace Otus\App\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use InvalidArgumentException;

class DataLoader
{
    private Client $client;
    private Config $config;

    public function __construct($elastic)
    {
        $this->client = $elastic->client;
        $this->config = $elastic->config;
    }

    /**
     * @throws Exception
     */
    public function loadFromFile(): void
    {
        $jsonFilePath = realpath(__DIR__ . '/../../' . $this->config->dataFile);

        if (!$jsonFilePath) {
            throw new Exception("File not found: $jsonFilePath");
        }

        $this->readAndIndex($jsonFilePath);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function readAndIndex(string $filePath): void
    {
        $bulkData = [];
        $file = fopen($filePath, 'r');

        while (($line = fgets($file)) !== false) {
            $actionData = json_decode($line, true);
            if (isset($actionData['create'])) {
                $bulkData[] = [
                    'index' => [
                        '_index' => $actionData['create']['_index'] ?? $this->config->indexName,
                        '_id' => $actionData['create']['_id'],
                    ]
                ];
            } else {
                $bulkData[] = $actionData;
            }
        }

        fclose($file);
        $this->bulkIndex($bulkData);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function bulkIndex(array $bulkData): void
    {
        if (empty($bulkData)) {
            throw new InvalidArgumentException("No data to index.");
        }

        $params = ['body' => $bulkData];
        $response = $this->client->bulk($params);
        echo "Successfully indexed documents. Bulk response: ";
        print_r($response);
        echo  PHP_EOL;
    }
}
