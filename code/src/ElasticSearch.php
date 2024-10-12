<?php

namespace AlexAgapitov\OtusComposerProject;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;
use Exception;

class ElasticSearch {

    private Client $client;

    private string $index = 'otus-shop';

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elastic:9200'])
            ->setBasicAuthentication('username', 'password')
            ->setSSLVerification(false)
            ->build();

        $this->client->info();
    }

    public function init() {
        if (!$this->deleteIndex()) {
            throw new Exception('Error delete index');
        }
        if (!$this->createIndex()) {
            throw new Exception('Error create index');
        }

        $data = explode("\n", file_get_contents(__DIR__.'/../books_39289_aa67f1-39289-6891db.json'));
        $body = [];
        foreach ($data as $item) {
            $item = json_decode($item, true);
            if (!empty($item) && count($body) <= 10) {
                $body[] = $item;
            }
        }

        $bulk = $this->bulk($body);

        if (empty($bulk) || !$bulk['errors']) {
            throw new Exception('Error in bulk index');
        }
    }

    private function deleteIndex()
    {
        $params = [
            'index' => $this->index,
        ];

        if ($this->client->indices()->exists($params)->asBool()) {
            return $this->client->indices()->delete($params)->getStatusCode();
        }
        return true;
    }

    private function createIndex()
    {
        $params = [
            'index' => $this->index
        ];
        return $this->client->indices()->create($params)->asBool();
    }

    public function search(string $params = null)
    {
        $query = json_decode($params, true);

        if (empty($query)) {
            throw new Exception('Error format in query');
        }

        $params = [
            'index' => $this->index,
            'body' => $query,
        ];

        $response = $this->client->search($params);

        $result = $this->prepareAnswer($response);

        if (!empty($result)) {
            echo "max_score: ". $result['hits']['max_score'] . PHP_EOL;
            echo "hits: ". count($result['hits']['hits']) . PHP_EOL;
        } else {
            throw new Exception('Error search');
        }
    }

    private function prepareAnswer($response)
    {
        return json_decode($response, true);
    }

    private function bulk(array $body)
    {
        $params = [
            'body' => $body,
        ];
        $response = $this->client->bulk($params);
        return $this->prepareAnswer($response);
    }
}