<?php

var_dump("Redis TEST");

$redis = new Redis();
//Connecting to Redis
$redis->connect('redis');
$redis->auth(['default', getenv('REDIS_PASSWORD')]);

if ($redis->ping()) {
    echo "PONG" . PHP_EOL;
}

$redis->set("test", "test");
echo $redis->get("test") . PHP_EOL;
