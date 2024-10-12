<?php

namespace VladimirGrinko\Redis; 

class Connect
{
    const COUNTER = 'events:counter';
    const ALL_EVENTS = 'events:all';
    const WEIGHTS = 'events:weights';
    const PARAMS = 'events:params';

    protected $redis;

    public function __construct()
    {
        $this->redis = new \Redis([
            'host' => 'redis',
        ]);
    }

    public function getRedis(): \Redis
    {
        return $this->redis;
    }
}