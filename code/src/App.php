<?php

declare(strict_types=1);

namespace IraYu\Hw11;

class App
{
    public function __construct(
        protected string $esHost,
        protected string $esPassword,
        protected string $esIndex,
    ) {
    }

    public function run(
        array $rawFilter
    ) {
        $esService = new Service\ESService($this->esHost, $this->esPassword);
        $filterService = new Service\FilterService($rawFilter);
        $client = $esService->createClient();

        $query = $filterService->getQuery('title');
        $filter = $filterService->getFilter();
        $search = [
            'index' => $this->esIndex,
            'body' => [
                'size' => 100,
                'query' => [
                    'bool' => [] +
                        ($query ? ['must' => $query] : []) +
                        ($filter ? ['filter' => $filter] : [])
                    ,
                ]
            ]
        ];
        $result = $client->search($search);

        (new View\BooksView())(($result->asArray())['hits']['hits']);
    }
}
