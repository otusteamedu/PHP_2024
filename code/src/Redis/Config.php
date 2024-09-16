<?php

namespace Otus\App\Redis;

readonly class Config
{
    public string $host;
    public string $port;
    public array $params;

    public function __construct()
    {
        $this->host = getenv('REDIS_HOST');
        $this->port = getenv('REDIS_PORT');
        $this->params = $this->getArguments();
    }

    private static function getArguments()
    {
        if (!isset($_SERVER['argv']) || !is_array($_SERVER['argv'])) {
            return [];
        }

        $argv = $_SERVER['argv'];
        $params = [];
        for ($i = 2; $i < count($argv); $i++) {
            $arg = explode('=', $argv[$i]);
            if (count($arg) === 2) {
                $params[$arg[0]] = $arg[1];
            }
        }

        return $params;
    }
}
