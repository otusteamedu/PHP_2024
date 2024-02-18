<?php

namespace helpers;

class MemcachedService
{
    private const DEFAULT_HOST = '127.0.0.1';
    private const DEFAULT_PORT = 11211;

    /**
     * @param string $host
     * @param int $port
     */
    public function __construct(
        private string $host = self::DEFAULT_HOST,
        private int $port = self::DEFAULT_PORT
    ) {
    }

    /**
     * @return false|string
     */
    public function ping()
    {
        try {
            $m = new \Memcached();
            $m->addServer($this->host, $this->port);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return json_encode($m->getVersion());
    }
}
