<?php

declare(strict_types=1);

namespace App\Shop\Search;

use App\Shared\Search\SearchCriteria;

final class SearchQueryBuilder
{
    private array $query = [
        'query' => [
            'bool' => [
                'must' => []
            ]
        ]
    ];

    public function build(): array
    {
        return $this->query;
    }

    public function all(): array
    {
        return [
            'query' => [
                'match_all' => []
            ]
        ];
    }

    public function fromSearchCriteria(?SearchCriteria $searchCriteria = null): array
    {
        if (null === $searchCriteria) {
            return $this->all();
        }

        foreach ($searchCriteria->getFilters() as $filter) {
            $condition = $filter->getCondition();

            match (true) {
                $condition === '=' => $this->addTermFilter($filter->getField(), $filter->getValue()),
                $condition === 'LIKE' => $this->addFulltextFilter($filter->getField(), $filter->getValue()),
                is_array($condition) => $this->addRangeFilter($filter->getField(), $filter->getCondition()),
            };
        }

        return $this->build();
    }

    public function addFulltextFilter(string $field, string $value): self
    {
        $this->query['query']['bool']['must'][] = [
            'match' => [
                $field => [
                    'query' => $value,
                    'fuzziness' => 'AUTO',
                ]
            ]
        ];

        return $this;
    }

    public function addRangeFilter(string $field, array $range): self
    {
        $this->query['query']['bool']['must'][] = [
            'range' => [
                $field => $range
            ]
        ];

        return $this;
    }

    public function addTermFilter(string $field, string $value): self
    {
        $this->query['query']['bool']['must'][] = [
            'term' => [
                $field . '.keyword' => $value
            ]
        ];

        return $this;
    }
}
