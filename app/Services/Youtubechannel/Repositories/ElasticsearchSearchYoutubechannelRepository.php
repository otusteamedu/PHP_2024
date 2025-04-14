<?php

namespace App\Services\Youtubechannel\Repositories;

use App\Models\Youtubechannel;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ElasticsearchSearchYoutubechannelRepository implements SearchYoutubechannelRepository
{
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $q): Collection
    {
        $items = $this->searchOnElasticsearchTitle($q);
        return $this->buildCollection($items);
    }

    private function searchOnElasticsearchTitle(string $query = ''): array
    {
        $model = new Youtubechannel();

        $response = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => ['name'],
                        'query' => $query . '*',
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true,
                    ],
                ],
            ],
        ]);

        return $response['hits']['hits'] ?? [];
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items, '_id');

        return Youtubechannel::findMany($ids)
            ->sortBy(function ($item) use ($ids) {
                return array_search($item->getKey(), $ids);
            });
    }
}
