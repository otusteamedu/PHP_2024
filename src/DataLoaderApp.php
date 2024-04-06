<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\elasticsearch\ElasticSearchClient;

class DataLoaderApp
{
    private ElasticSearchClient $elasticSearchClient;
    public function __construct(ElasticSearchClient $elasticSearchClient)
    {
        $this->elasticSearchClient = $elasticSearchClient;
    }

    public function run(): \Generator {
        try {
            print_r(getenv("ELK_DUMP_FILE_PATH"));
            $filePath = '../data/' . getenv("ELK_DUMP_FILE_PATH");
            $indexName = getenv("ELK_INDEX_NAME");
            $data = file_get_contents($filePath);
            $this->elasticSearchClient->bulk($indexName, $data);
            yield "Data loaded successfully";
        } catch (\Exception $exception) {
            yield $exception->getMessage();
        }
    }
}