<?php

declare(strict_types=1);

namespace App\Service;

use Redis;
use RedisException;

class RedisService
{
  /**
   * @return array
   * @throws RedisException
   */
  public function checkRedis(): array
  {
    $redis = new Redis();
    $connect = $redis->connect('redis');
    $auth = $redis->auth($_ENV['REDIS_PASSWORD']);

    return ['connect' => $connect, 'auth' => $auth];
  }
}
