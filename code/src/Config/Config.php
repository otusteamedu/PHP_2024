<?php

namespace Otus\App\Config;

readonly class Config
{
    public string $host;
    public int $port;
    public array $argv;
    public array $params;
    public string $sortedSetName;
    public ?string $query;

    public function __construct()
    {
        $this->host = getenv('REDIS_HOST');
        $this->port = (int)getenv('REDIS_PORT');
        $this->argv = $_SERVER['argv'];
        $this->sortedSetName = $_SERVER['argv'][2];
        $this->query = $_SERVER['argv'][3] ?? null;
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
        for ($i = 3; $i < count($this->argv); $i++) {
            $arg = explode('=', $this->argv[$i], 2);
            if (count($arg) === 2) {
                $params[$arg[0]] = $arg[1];
            }
        }

        return $params;
    }
}
