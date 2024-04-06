<?php

namespace AKornienko\Php2024;

readonly class Config
{
    public string $hostName;
    public string $port;
    public string $hostUrl;
    public string $userName;
    public string $password;
    public string $filePath;
    public string $indexName;

    public function __construct()
    {
        $this->hostName = getenv('ELK_HOST_NAME');
        $this->port = getenv('ELK_PORT');
        $this->hostUrl = "https://$this->hostName:$this->port";
        $this->userName = getenv("ELK_USER_NAME");
        $this->password = getenv("ELASTIC_PASSWORD");
        $this->filePath = '../data/' . getenv("ELK_DUMP_FILE_PATH");
        $this->indexName = getenv("ELK_INDEX_NAME");
    }
}
