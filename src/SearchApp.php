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
    public function run(): string
    {
        $searchParam = $this->getSearchParams();
        $results = $this->elasticSearchClient->search($searchParam);

        if (!count($results['hits'])) {
            return "Ничего не найдено";
        }

        return $this->getFormattedResults($results);
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
                if ($optionRaw[0] === 'title') {
                    $searchParam[] = SearchParam::title($optionRaw[1]);
                } else {
                    if ($optionRaw[0] === 'price') {
                        $searchParam[] = SearchParam::price($optionRaw[1]);
                    } else {
                        if ($optionRaw[0] === 'price-range') {
                            $searchParam[] = SearchParam::priceRange($optionRaw[1]);
                        }
                    }
                }
            }
        }
        return $searchParam;
    }

    private function getFormattedResults($results): string
    {
        $formattedResults = '';
        foreach ($results['hits'] as $hit) {
            $formattedResults .= "Название: {$hit['_source']['title']}, Категория: {$hit['_source']['category']}, Цена: {$hit['_source']['price']} руб.\n";
        }
        return $formattedResults;
    }
}
