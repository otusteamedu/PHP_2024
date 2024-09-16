<?php

declare(strict_types=1);

namespace Afilippov\Hw11;

class App
{
    public function run(): string
    {
        $config = new ElasticConfig();

        $arguments = new Arguments();

        $client = (new ElasticClient($config));

        $searchService = new SearchService($client, new Query());
        $result = $searchService->search($arguments);

        $resultsFormatter = new ResultsFormatter();
        return $resultsFormatter->formatResults($result['hits'] ?? []);
    }
}
