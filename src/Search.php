<?php

namespace Ahar\Hw11;

class Search
{
    public function __construct(
        private readonly Elastic $elastic,
    )
    {
    }

    public function search(SearchParams $searchParams): SearchResult
    {
        $client = $this->elastic->buildCClient();
        $querySearch = (new QueryBuilder())
            ->setQuery($searchParams->getQuery())
            ->setCategory($searchParams->getCategory())
            ->setMaxPrice($searchParams->getMaxPrice())
            ->setMinPrice($searchParams->getMinPrice());

        return new SearchResult($client->search(['index' => $searchParams->getIndex(), 'body' => $querySearch->getQuery()]));
    }
}
