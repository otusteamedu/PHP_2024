<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Controller;

use AlexanderPogorelov\ElasticSearch\Config;
use AlexanderPogorelov\ElasticSearch\Response\Response;
use AlexanderPogorelov\ElasticSearch\Response\ResponseInterface;
use AlexanderPogorelov\ElasticSearch\Service\ESClient;

class DataController
{
    private ESClient $client;
    private Config $config;

    public function __construct()
    {
        $this->client = new ESClient();
        $this->config = new Config();
    }

    /**
     * @throws \Exception
     */
    public function initAction(): ResponseInterface
    {
        $indexName = $this->config->getIndexName();

        if ($this->client->isIndexExist($indexName)) {
            $this->client->deleteIndex($indexName);
        }

        $this->client->createIndexWithParams($indexName, $this->config->getSettings(), $this->config->getProperties());

        $json = file_get_contents($this->config->getJsonPath());

        if (false === $json) {
            throw new \Exception('Json file not founded');
        }

        $this->client->bulkInsert($indexName, $json);

        return new Response('Initialization complete!');
    }

    public function addWithIdAction(string $id, string $json): ResponseInterface
    {
        $indexName = $this->config->getIndexName();
        $this->client->addWithId($indexName, $id, $json);

        return new Response('Data has been added successfully.');
    }

    public function getByIdAction(string $id): ResponseInterface
    {
        $indexName = $this->config->getIndexName();
        $responseData = $this->client->getById($indexName, $id);

        return new Response($responseData);
    }

    public function searchAllAction(): ResponseInterface
    {
        $indexName = $this->config->getIndexName();
        $responseData = $this->client->searchAll($indexName);

        return new Response($responseData);
    }

    public function searchByTitleAction(string $title): ResponseInterface
    {
        $indexName = $this->config->getIndexName();
        $responseData = $this->client->searchByTitle($indexName, $title);

        return new Response($responseData);
    }

    public function searchByCategoryAction(string $category): ResponseInterface
    {
        $indexName = $this->config->getIndexName();
        $responseData = $this->client->searchByCategory($indexName, $category);

        return new Response($responseData);
    }

    public function getMappingAction(): ResponseInterface
    {
        $indexName = $this->config->getIndexName();
        $responseData = $this->client->getMappings($indexName);

        return new Response($responseData);
    }
}
