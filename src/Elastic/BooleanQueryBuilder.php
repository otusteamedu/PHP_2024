<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Elastic;

class BooleanQueryBuilder
{
    private array $query = [];

    public function __construct()
    {
        $this->query['bool'] = [];
    }

    static public function match(string $field, mixed $query, bool $fuzzy = false): array
    {
        $parameters = ['query' => $query];
        if ($fuzzy) {
            $parameters['fuzziness'] = 'auto';
        }

        return ['match' => [$field => $parameters]];
    }

    static public function range(string $field, mixed $query, string $operator): array
    {
        return ['range' => [$field => [$operator => $query]]];
    }

    static public function term(string $field, mixed $query): array
    {
        return ['term' => [$field => $query]];
    }

    static public function nested(string $path, array $query): array
    {
        return ['nested' => ['path' => $path, 'query' => $query]];
    }

    public function addFilter(array $data): self
    {
        $this->query['bool']['filter'][] = $data;

        return $this;
    }

    public function addMust(array $data): self
    {
        $this->query['bool']['must'][] = $data;

        return $this;
    }

    public function addShould(array $data): self
    {
        $this->query['bool']['should'][] = $data;

        return $this;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
