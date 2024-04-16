<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Elasticsearch;

class BoolQuery
{
    private array $query;

    public function __construct()
    {
        $this->query = ['bool' => []];
    }

    public function addToMust(array $queryPart): self
    {
        $this->query['bool']['must'][] = $queryPart;
        return $this;
    }

    public function addToFilter(array $queryPart): self
    {
        $this->query['bool']['must'][] = $queryPart;
        return $this;
    }

    public function addToShould(array $queryPart): self
    {
        $this->query['bool']['should'][] = $queryPart;
        return $this;
    }

    public function addToMustNot(array $queryPart): self
    {
        $this->query['bool']['must_not'][] = $queryPart;
        return $this;
    }

    public function asArray(): array
    {
        return $this->query;
    }
}
