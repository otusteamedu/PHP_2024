<?php

namespace Otus\App\Redis;

readonly class Config
{
    public string $host;
    public string $port;
    public array $argv;
    public array $params;

    public function __construct()
    {
        $this->host = getenv('REDIS_HOST');
        $this->port = getenv('REDIS_PORT');
        $this->argv = $_SERVER['argv'];
        $this->params = $this->getArguments();
    }

    /**
     * @return array
     */
    private function getArguments(): array
    {
        if (!isset($_SERVER['argv']) || !is_array($_SERVER['argv'])) {
            return [];
        }

        $params = [];
        for ($i = 2; $i < count($this->argv); $i++) {
            $arg = explode('=', $this->argv[$i], 2);
            if (count($arg) === 2) {
                $params[$arg[0]] = $arg[1];
            }
        }

        return $params;
    }
}
