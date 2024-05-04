<?php

namespace Ahar\Hw11;

use Elastic\Elasticsearch\Response\Elasticsearch;

class SearchResult
{
    public function __construct(
        private readonly Elasticsearch $elasticsearch,
    )
    {
    }

    public function searchResult():string
    {
        if (empty($this->elasticsearch['hits'])) {
            return "Ничего не найдено.\n";
        }
        $result = [];

        foreach ($this->elasticsearch['hits']['hits'] as $hit) {
            $result[] = sprintf("Название: %s, Категория: %s, Цена: %s, Id: %s", $hit['_source']['title'], $hit['_source']['category'], $hit['_source']['price'], $hit['_id']);
        }
        return implode("\n", $result);
    }
}
