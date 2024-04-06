<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\elasticsearch\ElasticSearchClient;
use Exception;

class SearchApp
{
    private ElasticSearchClient $elasticSearchClient;

    public function __construct(ElasticSearchClient $elasticSearchClient)
    {
        $this->elasticSearchClient = $elasticSearchClient;
    }

    /**
     * @throws Exception
     */
    public function run(): \Generator
    {
        $searchParam = $this->getSearchParams();
        $results = $this->elasticSearchClient->search($searchParam);

        if (!count($results['hits'])) {
            yield "Ничего не найдено";
            return;
        }

        yield $this->getFormattedResults($results);
    }

    /**
     * @throws Exception
     */
    private function getSearchParams(): array
    {
        $searchParam = [];
        for ($i = 2; $i < count($_SERVER['argv']); $i++) {
            $optionRaw = explode("=", $_SERVER['argv'][$i]);
            if (count($optionRaw) === 2) {
                $searchParam[] = new SearchParam($optionRaw[0], $optionRaw[1]);
            }
        }
        return $searchParam;
    }

    private function getFormattedResults($results): string {
        $formattedResults = '';
        foreach ($results['hits'] as $hit) {
            $formattedResults .= "Название: {$hit['_source']['title']}, Категория: {$hit['_source']['category']}, Цена: {$hit['_source']['price']} руб.\n";
        }
        return $formattedResults;
    }
}