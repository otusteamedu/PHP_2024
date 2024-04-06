<?php

namespace AKornienko\Php2024;
use \AKornienko\Php2024\elasticsearch\ElasticSearchClient;
use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): \Generator
    {
        $hostName = getenv('ELK_HOST_NAME');
        $port = getenv('ELK_PORT');
        $hostUrl = "https://$hostName:$port";
        $userName = getenv("ELK_USER_NAME");
        $password = getenv("ELASTIC_PASSWORD");
        $client = new ElasticSearchClient($hostUrl, $userName, $password);

        switch ($this->getAppType()) {
            case 'init':
                $dataLoader = new DataLoaderApp($client);
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