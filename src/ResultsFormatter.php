<?php

declare(strict_types=1);

namespace Afilippov\Hw11;

class ResultsFormatter
{
    public function formatResults(array $results): string
    {
        $formattedResults = '';
        if (empty($results['hits'])) {
            return "Ничего не найдено.\n";
        }
        foreach ($results['hits'] as $hit) {
            $formattedResults .= "Название: {$hit['_source']['title']}, Категория: {$hit['_source']['category']}, Цена: {$hit['_source']['price']} руб.\n";
        }
        return $formattedResults;
    }
}
