<?php

declare(strict_types=1);

namespace hw15\redis;

use \Redis;

class Test
{
    public function exec()
    {
        try {
            $redis = new Redis([
                'host' => getenv('REDIS_HOST'),
                'port' => (int)getenv('REDIS_PORT'),
                'connectTimeout' => 2.5
            ]);
            $result = $redis->ping('Test redis');
        } catch (\Throwable $e) {
            $result = $e->getMessage();
        }

        return $result;
    }
}
