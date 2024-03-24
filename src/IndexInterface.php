<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

interface IndexInterface
{
    public function create(): void;
    public function search(array $options): Elasticsearch|Promise;
}
