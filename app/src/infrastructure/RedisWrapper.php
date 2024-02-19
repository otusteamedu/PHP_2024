<?php

namespace Akornienko\App\infrastructure;

use Redis;

class RedisWrapper
{
    public function connect(): void {
        $redisHost = getenv("REDIS_HOST");
        $redisPort = getenv("REDIS_PORT");

        $redis = new Redis();
        try {
            $redis->connect($redisHost, $redisPort);
            if ($redis->ping()) {
                print_r("<br>");
                print_r("redis connected");
            }
        } catch (Exception $e) {
            print_r("<br>");
            echo $e->getMessage();
        }
    }
}