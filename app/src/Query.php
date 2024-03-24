<?php

declare(strict_types=1);

namespace Lrazumov\Hw14;

class Query
{
    private array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getQuery(): array
    {
        $query = [];
        if (isset($this->options['query'])) {
            $query['query'] = $this->options['query'];
        }
        if (isset($this->options['gte'])) {
            $query['gte'] = $this->options['gte'];
        }
        if (isset($this->options['lte'])) {
            $query['lte'] = $this->options['lte'];
        }
        if (isset($this->options['category'])) {
            $query['category'] = $this->options['category'];
        }
        if (isset($this->options['shop'])) {
            $query['shop'] = $this->options['shop'];
        }
        return $query;
    }
}
