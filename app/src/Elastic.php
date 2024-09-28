<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

use Elastic\Elasticsearch\ClientBuilder;
use Exception;

class Elastic
{
    private $password;
    private $host;
    private $port;
    public $client;
    protected $pathToFileBooks;
    protected $pathToFileSettings;
    protected $indexName;

    public function __construct()
    {
        $config = ElasticConfig::load();

        $this->password = $config['password'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->pathToFileBooks = $config['pathToFileBooks'];
        $this->pathToFileSettings = $config['pathToFileSettings'];
        $this->indexName = $config['indexName'];

        $this->client = ClientBuilder::create()
            ->setHosts(["http://" . $this->host . ":" . $this->port])
            ->setBasicAuthentication("elastic", $this->password)
            ->setSSLVerification(false)
            ->build();
    }

    public function search($params)
    {

        $query = Filter::prepareFilter($params);

        $params = [
            'index' => $this->indexName,
            'body' => $query
        ];

        $result = $this->client->search($params);

        Output::renderTable($result['hits']);
    }
}
