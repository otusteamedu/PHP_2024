<?php

declare(strict_types=1);

namespace App\Shared\Search;

use App\Shared\Exception\SearchClientException;
use App\Shop\Search\ElasticsearchClient;

final readonly class SearchClientFactory
{
    public function make(): SearchClientInterface
    {
        return match (getenv('SEARCH_CLIENT')) {
            'elasticsearch' => new ElasticsearchClient(),
            default => throw new SearchClientException('No client specified'),
        };
    }
}
