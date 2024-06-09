<?php

declare(strict_types=1);

namespace Dsergei\Hw11;

class ElasticsearchQueryResponse
{
    public function __construct(
        private array $response
    ) {
    }

    public function getResponse()
    {
        $response = [];
        if (empty($this->response['hits'])) {
            return "Ничего не найдено.\n";
        }
        foreach ($this->response['hits']['hits'] as $hit) {
            if (empty($hit['_source'])) {
                continue;
            }
            $response[] = "Название: {$hit['_source']['title']}, Категория: {$hit['_source']['category']}, Цена: {$hit['_source']['price']} руб";
        }
        return implode("\n", $response) . PHP_EOL;
    }
}