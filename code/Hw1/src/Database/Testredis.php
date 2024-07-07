<?php

namespace Dmigrishin\FirstHomework\Database;

class Testredis 
{

    static function testRedis()
    {
        $redis = new \Redis();
        $redis->connect('redis', 6379);
        
        if ($redis->ping()) {
            echo "Redis is running" . "<br/>";
        }
    }
    
}