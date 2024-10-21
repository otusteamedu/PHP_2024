<?php

namespace  Otus\App\Elastic;

use InvalidArgumentException;

readonly class Config
{
    public string $host;
    public string $port;
    public string $userName;
    public string $password;
    public string $dataFile;
    public string $indexName;
    public array $searchParams;

    public function __construct()
    {
        $this->host = getenv('ELASTIC_CONTAINER');
        $this->port = getenv('ELASTIC_PORT');
        $this->userName = getenv('ELASTIC_USERNAME');
        $this->password = getenv('ELASTIC_PASSWORD');
        $this->dataFile = getenv('ELASTIC_DATA_FILE');
        $this->indexName = getenv('ELASTIC_INDEX');
        $this->searchParams = $this->getArguments();
    }

    /**
     * @return array
     */
    private static function getArguments(): array
    {
        if (!isset($_SERVER['argv']) || !is_array($_SERVER['argv'])) {
            return [];
        }

        $argv = $_SERVER['argv'];
        $searchParams = [];
        for ($i = 2; $i < count($argv); $i++) {
            $arg = explode('=', $argv[$i]);

            if (count($arg) !== 2) {
                throw new InvalidArgumentException(
                    "Wrong input parameters format!" . PHP_EOL .
                    'Please check the documentation!'
                );
            }

            $searchParams[$arg[0]] = str_contains($arg[1], ':') ? explode(':', $arg[1]) : $arg[1];
        }

        return $searchParams;
    }
}
