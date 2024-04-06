<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\elasticsearch\ElasticSearchClient;
use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): string
    {
        $config = new Config();
        $client = new ElasticSearchClient(new Config());

        switch ($this->getAppType()) {
            case 'init':
                $dataLoader = new DataLoaderApp($client, $config);
                return $dataLoader->run();
            case 'search':
                $searchApp = new SearchApp($client);
                return $searchApp->run();
            default:
                throw new Exception("Wrong app type");
        }
    }

    private function getAppType(): string
    {
        return $_SERVER['argv'][1] ?? '';
    }
}
