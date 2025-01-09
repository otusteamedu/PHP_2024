<?php

namespace AnatolyShilyaev\App\Elastic;

readonly class Config
{
    public string $host;
    public string $port;
    public string $userName;
    public string $password;
    public string $dataFile;
    public string $indexName;

    public function __construct()
    {
        $this->host = getenv('ELASTIC_CONTAINER');
        $this->port = getenv('ELASTIC_PORT');
        $this->userName = getenv('ELASTIC_USERNAME');
        $this->password = getenv('ELASTIC_PASSWORD');
        $this->dataFile = getenv('ELASTIC_DATA_FILE');
        $this->indexName = getenv('ELASTIC_INDEX');
    }
}
