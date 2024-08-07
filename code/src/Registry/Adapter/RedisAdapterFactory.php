<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry\Adapter;

use Redis;
use Viking311\Analytics\Config\Config;
use Viking311\Analytics\Registry\Adapter\RedisAdapter;

class RedisAdapterFactory 
{
    public static function getInstance() : RedisAdapter {
        $config  = new Config();

        $redisClient = new Redis([
            'host' => $config->redisHost,
            'port' => $config->redisPort
        ]);
        
        $redisClient->select(0);

        return new RedisAdapter($redisClient);
    }                
}
