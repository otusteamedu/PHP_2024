<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\elasticsearch\ElasticSearchClient;

class DataLoaderApp
{
    private ElasticSearchClient $elasticSearchClient;
    private Config $config;

    public function __construct(ElasticSearchClient $elasticSearchClient, Config $config)
    {
        $this->elasticSearchClient = $elasticSearchClient;
        $this->config = $config;
    }

    public function run(): string
    {
        try {
            $data = file_get_contents($this->config->filePath);
            $this->elasticSearchClient->bulk($this->config->indexName, $data);
            return "Data loaded successfully";
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
