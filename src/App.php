<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

class App
{
    public function run(): string
    {
        $config = new ElasticConfig();
        $arguments = new Arguments();
        $client = (new ElasticClient($config));

        $searchService = new SearchService($client, new Query());
        $result = $searchService->search($arguments);

        $resultsFormatter = new Formatter();
        return $resultsFormatter->formatResults($result['hits'] ?? []);
    }

}