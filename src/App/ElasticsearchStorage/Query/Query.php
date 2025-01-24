<?php

namespace App\ElasticsearchStorage\Query;

interface Query
{
    public function getIndex(): string;
    public function getMapping(): array;
    public function createDocQuery(array $data): array;
}