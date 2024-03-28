<?php

declare(strict_types=1);

use Hukimato\RedisApp\Models\Events\Event;

require_once __DIR__ . '/../vendor/autoload.php';

const PARAMS_NAME = ['a', 'b', 'c', 'd', 'e'];

function randString()
{
    return substr(md5(microtime()), rand(0, 26), 5);
}

function randEvent()
{
    $event['priority'] = rand(1, 1000);
    $event['eventName'] = randString();
    foreach (PARAMS_NAME as $param) {
        if (rand(1, 5) % 2) continue;
        $event['params'][$param] = rand(1, 5);
    }
    return $event;
}

$redis = new Redis();
$redis->connect('redis');
$redis->auth(['default', 'hukimato']);

for ($i = 0; $i < 100; $i++) {
    (new Event(randEvent()))->save();
}
