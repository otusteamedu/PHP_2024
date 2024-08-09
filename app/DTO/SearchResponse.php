<?php

namespace App\DTO;

readonly class SearchResponse
{
    public int $took;
    public bool $timedOut;
    public Shards $shards;
    public int $totalHits;
    public array $hits;

    public function __construct(array $response)
    {
        $this->took = $response['took'] ?? 0;
        $this->timedOut = $response['timed_out'] ?? false;
        $this->shards = new Shards($response['_shards']);
        $this->totalHits = $response['hits']['total']['value'] ?? 0;
        $this->hits = $this->parseHits($response['hits']['hits'] ?? []);
    }

    private function parseHits(array $hitsArray): array
    {
        $hits = [];
        foreach ($hitsArray as $hit) {
            $hits[] = new Hit(
                $hit['_index'] ?? '',
                $hit['_id'] ?? '',
                $hit['_score'] ?? 0.0,
                $hit['_source']['title'] ?? '',
                $hit['_source']['sku'] ?? '',
                $hit['_source']['category'] ?? '',
                $hit['_source']['price'] ?? 0,
                $this->parseStock($hit['_source']['stock'] ?? [])
            );
        }
        return $hits;
    }

    private function parseStock(array $stockArray): array
    {
        $stock = [];
        foreach ($stockArray as $store) {
            $stock[] = new Stock(
                $store['shop'] ?? '',
                $store['stock'] ?? 0
            );
        }
        return $stock;
    }
}
