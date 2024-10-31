<?php
namespace App\Data;

use Elasticsearch\ClientBuilder;

class ElasticSearchClient {
    private $client;
    private $index;

    public function __construct($config) {
        $this->client = ClientBuilder::create()->setHosts($config['hosts'])->build();
        $this->index = $config['index'];
    }

    public function createIndex($settings) {
        if (!$this->client->indices()->exists(['index' => $this->index])) {
            $this->client->indices()->create(['index' => $this->index, 'body' => $settings]);
        }
    }

    public function indexProduct($product) {
        $this->client->index([
            'index' => $this->index,
            'body' => $product,
        ]);
    }

    public function search($params) {
        return $this->client->search([
            'index' => $this->index,
            'body'  => $params,
        ]);
    }
}
