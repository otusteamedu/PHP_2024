<?php

namespace Otus\App\Elastic;

use Exception;

class Data
{
    private \Elastic\Elasticsearch\Client $client;
    private Config $config;

    public function __construct($elastic)
    {
        $this->client = $elastic->client;
        $this->config = $elastic->config;
    }

    public function loadFromFile()
    {
        $jsonFilePath = realpath(__DIR__ . '/../../' . $this->config->dataFile);

        if (!file_exists($jsonFilePath)) {
            echo "File not found: $jsonFilePath" . PHP_EOL;
            return;
        }

        try {
            $this->readAndIndex($jsonFilePath);
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . PHP_EOL;
        }
    }

    private function readAndIndex(string $filePath)
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

    private function bulkIndex(array $bulkData)
    {
        if (empty($bulkData)) {
            echo "No data to index." . PHP_EOL;
            return;
        }

        $params = ['body' => $bulkData];
        $response = $this->client->bulk($params);
        echo "Successfully indexed documents. Bulk response: ";
        print_r($response);
        echo  PHP_EOL;
    }
}
