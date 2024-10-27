<?php

namespace VladimirGrinko\ElasticSearch;

use \Elastic\Elasticsearch\{
    Response\Elasticsearch as ResEs
};

class Search
{
    private $client;
    private $index;

    public function __construct(\Elastic\Elasticsearch\Client $client)
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

    public function paramsSearch(array $userParams, int $from = 1): ResEs
    {

        $params = [
            'index' => $this->index
        ];

        $params['body']['from'] = $from;

        $arrStock = explode('-', $userParams['stock']);

        $paramsQuery = new Build(
            $userParams['title'],
            $userParams['category'],
            is_numeric($userParams['price']['bot']) ? $userParams['price']['bot'] : null,
            is_numeric($userParams['price']['top']) ? $userParams['price']['top'] : null,
            isset($arrStock[0]) ? $arrStock[0] : '',
            isset($arrStock[1]) ? $arrStock[1] : null,
        );
        $params['body']['query'] = $paramsQuery->getParams();
        
        return $this->client->search($params);
    }
}
