<?php

declare(strict_types=1);

if (! function_exists('isRedisConnected')) {
    function isRedisConnected(): bool {
        $redis = new Redis();

        try {
            $redis->connect('redis');

            return $redis->ping();
        } catch (Throwable $e) {
            return false;
        }
    }
}