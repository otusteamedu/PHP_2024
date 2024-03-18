<?php

declare(strict_types=1);

if (! function_exists('isMemcachedConnected')) {
    function isMemcachedConnected(): bool
    {
        $memcached = new Memcached();

        try {
            $memcached->addServer(getenv('MEMCACHED_HOST'), (int) getenv('MEMCACHED_PORT'));
        } catch (Throwable $e) {
            return false;
        }

        $memcached->set('key', 1);

        return $memcached->getResultCode() === Memcached::RES_SUCCESS && !empty($memcached->get('key'));
    }
}
