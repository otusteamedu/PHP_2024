<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Controller;

use AlexanderPogorelov\ElasticSearch\Config;
use AlexanderPogorelov\ElasticSearch\Response\ResponseInterface;
use AlexanderPogorelov\ElasticSearch\Response\SearchResponse;
use AlexanderPogorelov\ElasticSearch\Service\ESClient;
use AlexanderPogorelov\ElasticSearch\Service\PromptService;
use AlexanderPogorelov\ElasticSearch\Service\QueryBuilder;
use AlexanderPogorelov\ElasticSearch\Validator\PromptValidator;

class SearchController
{
    private ESClient $client;
    private Config $config;

    public function __construct()
    {
        $this->client = new ESClient();
        $this->config = new Config();
    }

    public function searchAction(): ResponseInterface
    {
        $searchDto = (new PromptService(new PromptValidator()))->readInput();
        $query = (new QueryBuilder($searchDto, new Config()))->createQuery();
        $indexName = $this->config->getIndexName();
        $responseData = $this->client->searchByQuery($indexName, $query);

        return new SearchResponse($responseData);
    }
}
