<?php

namespace Otus\App\Redis;

use Exception;
use Redis;
use RedisException;

class Entry
{
    private Redis $client;
    public Config $config;

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function __construct()
    {
        $this->config = new Config();
        $this->client = new Redis();

        $connected = $this->client->connect($this->config->host, $this->config->port);
        if (!$connected) {
            throw new Exception('Could not connect to Redis');
        }
    }

    /**
     * @throws RedisException
     */
    public function add(string $priority, string $conditions, string $event): false|int|Redis
    {
        return $this->client->zAdd('events', $priority, json_encode([
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event
        ]));
    }

    /**
     * @throws RedisException
     */
    public function clear(): false|int|Redis
    {
        return $this->client->del('events');
    }

    /**
     * @throws RedisException
     */
    public function get(string $searchParams)
    {
        $position = 0;
        $eventsLength = $this->client->zCard('events');

        while ($position < $eventsLength) {
            $result = $this->client->zRevRangeByScore(
                'events',
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
}
