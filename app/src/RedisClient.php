<?php

declare(strict_types=1);

namespace Evgenyart\Hw12;

use Redis;

class RedisClient
{
    private $redis;
    private const REDISKEY = 'events';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    public function addEvent($params)
    {
        $data = StringHelper::parseString($params, 'add');
        $result = $this->redis->zAdd(self::REDISKEY, $data['priority'], $data['data']);
        OutputHelper::outputResultAdd($result);
    }

    public function getEvent($params)
    {
        $searcData = StringHelper::parseString($params, 'get');
        $events = $this->redis->zRevRange(self::REDISKEY, 0, -1);
        $result = MatchHelper::matchResult($searcData, $events);
        OutputHelper::outputResultGet($result);
    }

    public function clearEvents()
    {
        $result = $this->redis->del(self::REDISKEY);
        OutputHelper::outputResultClear($result);
    }
}
