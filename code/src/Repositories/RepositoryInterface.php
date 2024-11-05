<?php

namespace Naimushina\ElasticSearch\Repositories;

interface RepositoryInterface
{
    /**
     * Форматирование запроса для поиска в Elastic Search
     * @param array $params
     * @return array
     */
    public function formatSearchParams(array $params): array;
}
