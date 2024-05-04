<?php

namespace Ahar\Hw11;

class Application
{
    public function run(): string
    {
        $searchParams = new SearchParams();
        $clientBuilder = new Elastic(new ElasticConfig());

        $search = new Search($clientBuilder);
        return $search->search($searchParams)->searchResult();
    }
}
