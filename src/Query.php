<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

class Query
{
    public function get(QueryParams $queryParams): array
    {
        $query = [
            'query' => [
                'bool' => [
                    'must' => []
                ]
            ]
        ];

        if ($queryParams->searchQuery !== '') {
            $query['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $queryParams->searchQuery,
                        'fuzziness' => 'AUTO',
                    ]
                ]
            ];
        }


        if ($queryParams->category !== '') {
            $query['query']['bool']['filter'][] = [
                'term' => [
                    'category.keyword' => $queryParams->category
                ]
            ];
        }

        if ($queryParams->maxPrice !== 0) {
            $query['query']['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'lt' => $queryParams->maxPrice
                    ]
                ]
            ];
        }

        if ($queryParams->minPrice !== 0) {
            $query['query']['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'gt' => $queryParams->minPrice
                    ]
                ]
            ];
        }

        return $query;
    }

}