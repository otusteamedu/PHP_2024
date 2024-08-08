<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry\Adapter;

use Memcached;
use Viking311\Analytics\Config\Config;

class MemcachedAdapterFactory
{
    /**
     * @return MemcachedAdapter
     */
    public static function createInstance(): MemcachedAdapter
    {
        $config  = new Config();

        $memcached = new Memcached();
        $memcached->addServer(
            $config->memcachedHost,
            $config->memcachedPort
        );

        return new MemcachedAdapter($memcached);
    }
}
