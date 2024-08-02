<?php

declare(strict_types=1);

namespace Viking311\Books\Command;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Viking311\Books\Search\ClientFactory;

class SearchCommandFactory
{
    /**
     * @return SearchCommand
     * @throws AuthenticationException
     */
    public static function createInstance(): SearchCommand
    {
        $searchClient = ClientFactory::createInstance();

        return new SearchCommand($searchClient);
    }
}
