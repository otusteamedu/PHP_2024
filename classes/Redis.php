<?php

namespace classes;

use Predis\Client;

class Redis
{
    private const DEFAULT_HOST = '127.0.0.1';
    private const DEFAULT_PORT = 6379;
    private const DEFAULT_TIMEOUT = 0.8;

    /**
     * @param string $host
     * @param int $port
     * @param float $timeout
     */
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

    /**
     * @return Client
     */
    private function getClient(): Client
    {
        return new Client([
            'host' => $this->host,
            'port' => $this->port,
            'timeout' => $this->timeout
        ]);
    }
}
