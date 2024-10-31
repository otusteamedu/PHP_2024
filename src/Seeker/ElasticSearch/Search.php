<?php

namespace VladimirGrinko\Seeker\ElasticSearch;

use \Elastic\Elasticsearch\{
    Response\Elasticsearch as ResEs,
    Client as EsClient
};

class Search
{
    private EsClient $client;
    private string $index;

    public function __construct(EsClient $client)
    {
        $this->client = $client;
        $this->index = getenv('ELASTIC_INDEX');
    }

    public function skuSearch(string $sku): ResEs
    {
        $params = [
            'index' => $this->index,
            'id' => $sku
        ];
        return $this->client->get($params);
    }

    public function paramsSearch(Build $build, int $from = 1): ResEs
    {

        $params = [
            'index' => $this->index
        ];

        $params['body']['from'] = $from;

        $params['body']['query'] = $build->getParams();
        
        return $this->client->search($params);
    }
}
