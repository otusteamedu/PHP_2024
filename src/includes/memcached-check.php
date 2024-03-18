<?php

declare(strict_types=1);

if (! function_exists('isMemcachedConnected')) {
    function isMemcachedConnected(): bool
    {
        return (new Memcached())->addServer('memcached', 11211);
    }
}