<?php

declare(strict_types=1);

namespace OtusRedis\App\Redis;

use Predis\Client as PredisClient;

class RedisStorage
{
    public PredisClient $redis;

    public function __construct(string $host, int $port)
    {
        $this->redis = new PredisClient([
            'host' => $host,
            'port' => $port,
        ]);
    }

    /**
     * @param string $key
     * @param array $value
     * @return bool
     */
    public function add(string $key, array $value): bool
    {
        return (bool)$this->redis->zadd($key, $value);
    }

    /**
     * @param string $key
     * @param string $searchParams
     * @return string
     */
    public function get(string $key, string $searchParams): string
    {
        $position = 0;
        $eventsLength = $this->redis->zcard($key);

        while ($position < $eventsLength) {
            $result = $this->redis->zrevrangebyscore(
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
                return $decodedResult->event ?? 'No' . $key . ' found';
            }
        }

        return 'No events found';
    }

    /**
     * @param string $key
     * @return bool
     */
    public function clear(string $key): bool
    {
        return (bool)$this->redis->del($key);
    }
}
