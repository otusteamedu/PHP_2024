<?php

namespace classes;

class Manager
{
    public function __construct(
        private RedisService $redisService
    ) {
    }

    public function checking()
    {
        return $this->redisService->ping();
    }
}
