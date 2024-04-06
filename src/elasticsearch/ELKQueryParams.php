<?php

namespace AKornienko\Php2024\elasticsearch;

class ELKQueryParams
{
    private array $params = [
        'body' => [
            'query' => []
        ]
    ];

    private array $match = [];
    private array $range = [];

    public function __construct(array $searchParams, string $index)
    {
        $this->params['index'] = $index;
        foreach ($searchParams as $searchParam) {
            $key = $searchParam->key;
            $type = $searchParam->type;
            if ($type === 'string') {
                $this->match[$key] = [
                    'query' => $searchParam->value,
                    'fuzziness' => 'auto'
                ];
            } else {
                if ($type === 'number') {
                    $this->match[$key] = $searchParam->value;
                } else {
                    if ($type === 'range') {
                        $this->range[$key] = [
                            'gte' => $searchParam->value[0],
                            'lte' => $searchParam->value[1],
                        ];
                    }
                }
            }
        }
    }

    public function getParams(): array
    {
        if (count($this->match)) {
            $this->params['body']['query']['bool']['must']['match'] = $this->match;
        }
        if (count($this->range)) {
            $this->params['body']['query']['bool']['filter']['range'] = $this->range;
        }
        return $this->params;
    }
}
