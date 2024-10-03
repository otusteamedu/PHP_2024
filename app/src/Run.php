<?php

declare(strict_types=1);

namespace Evgenyart\Hw12;

class Run implements CommandsInterface
{
    public static function addEvent($params)
    {
        $redisClient = new RedisClient();
        $redisClient->addEvent($params);
    }

    public static function getEvent($params)
    {
        $redisClient = new RedisClient();
        $redisClient->getEvent($params);
    }

    public static function clearEvents()
    {
        $redisClient = new RedisClient();
        $result = $redisClient->clearEvents();
    }
}
