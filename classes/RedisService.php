<?php

namespace classes;

use Predis\Client;

class RedisService
{
    const DEFAULT_HOST = 'redis';
    const DEFAULT_PORT = 6379;
    const DEFAULT_TIMEOUT = 0.8;

    public function __construct(
        private string $host = self::DEFAULT_HOST,
        private int $port = self::DEFAULT_PORT,
        private float $timeout = self::DEFAULT_TIMEOUT
    ) {
    }

    /**
     * @return mixed|string
     */
    public function ping()
    {
        $redis = $this->getClient();

        try {
            return $redis->ping();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function getClient(): Client
    {
        return new Client([
            'host' => $this->host,
            'port' => $this->port,
            'timeout' => $this->timeout
        ]);
    }
}
