<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

class Formatter
{
    public function formatResults(array $results): string
    {
        $formattedResults = '';
        if (empty($results['hits'])) {
            return "Ничего не найдено.\n";
        }
        foreach ($results['hits'] as $hit) {
            $title = "Название: {$hit['_source']['title']}";
            $category = "Категория: {$hit['_source']['category']}";
            $price = "Цена: {$hit['_source']['price']} руб.\n";
            $formattedResults .= $title . "," . $category . ',' .  $price;
        }
        return $formattedResults;
    }
}
