<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

use Elastic\Elasticsearch\Client;
use Exception;

class IndexFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $indexName, Client $client): IndexInterface
    {
        if (!str_contains($indexName, '-')) {
            throw new Exception('Wrong index name');
        }

        $explodeIndex = explode('-', $indexName);
        $indexClass = __NAMESPACE__ . '\Indexes\\' . ucfirst($explodeIndex[0]) . ucfirst($explodeIndex[1]);

        if (class_exists($indexClass)) {
            return new $indexClass($indexName, $client);
        }

        throw new Exception('Index class not found');
    }
}
