<?php

declare(strict_types=1);

namespace Otus\App\Storage\Redis;

use Otus\App\Storage\StorageInterface;
use Redis;
use RedisException;

class RedisStorage implements StorageInterface
{
    private Redis $redis;

    public function __construct(string $host, int $port)
    {
        $this->redis = new Redis([
            'host' => $host,
            'port' => $port,
        ]);
    }

    /**
     * @param string $key
     * @param string $priority
     * @param string $value
     * @return bool
     * @throws RedisException
     */
    public function add(string $key, string $priority, string $value): bool
    {
        return (bool)$this->redis->zAdd($key, $priority, $value);
    }

    /**
     * @param string $key
     * @param string $searchParams
     * @return string
     * @throws RedisException
     */
    public function get(string $key, string $searchParams): string
    {
        $position = 0;
        $eventsLength = $this->redis->zCard($key);

        while ($position < $eventsLength) {
            $result = $this->redis->zRevRangeByScore(
                $key,
                '+inf',
                '-inf',
                ['limit' => [$position++, 1]]
            )[0];

            if (!$result) {
                continue;
            }

            $decodedResult = json_decode($result);
            if (
                $decodedResult &&
                (!isset($decodedResult->conditions) || $decodedResult->conditions === $searchParams)
            ) {
                return $decodedResult->event ?? 'No events found';
            }
        }

        return 'No events found';
    }

    /**
     * @param string $key
     * @return bool
     * @throws RedisException
     */
    public function clear(string $key): bool
    {
        return (bool)$this->redis->del($key);
    }
}
