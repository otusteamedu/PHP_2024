<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry\Adapter;

use Redis;
use Viking311\Analytics\Registry\Adapter\AdapterInterface;

class RedisAdapter implements AdapterInterface
{   
    /**
     *
     * @param Redis $redisClient
     */
    public function __construct(private Redis $redisClient)
    {
        
    }

    public function flush(): void
    {
        $this->redisClient->flushDB();
    }
}
