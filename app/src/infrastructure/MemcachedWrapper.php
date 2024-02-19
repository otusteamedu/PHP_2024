<?php

namespace Akornienko\App\infrastructure;

use Memcached;

class MemcachedWrapper
{
    public function connect(): void {
        $memcachedHost = getenv("MEMCACHED_HOST");
        $memcachedPort = getenv("MEMCACHED_PORT");

        $memcached = new Memcached();
        $memcached->addServer($memcachedHost, $memcachedPort);
        print_r("<br>");
        print_r($memcached->getVersion());
    }
}