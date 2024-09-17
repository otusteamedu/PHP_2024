<?php

namespace Otus\App\Redis;

class Entry
{
    private \Redis $client;
    public Config $config;

    public function __construct()
    {
        $this->config = new Config();
        $this->client = new \Redis();

        $connected = $this->client->connect($this->config->host, $this->config->port);
        if (!$connected) {
            throw new \Exception('Could not connect to Redis');
        }
    }

    public function add($priority, $conditions, $event)
    {
        $result = $this->client->zAdd('events', $priority, json_encode([
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event
        ]));
        return $result;
    }

    public function clear()
    {
        $result = $this->client->del('events');
        return $result;
    }

    public function get($searchParams)
    {
        $position = 0;
        $eventsLength = $this->client->zCard('events');
        while ($position < $eventsLength) {
            $result = $this->client->zRevRangeByScore('events', '+inf', '-inf', ['limit' => [$position++, 1]])[0];
            if (!$result) {
                continue;
            }
            $decodedResult = json_decode($result);
            if ($decodedResult && (!isset($decodedResult->conditions) || $decodedResult->conditions === $searchParams)) {
                return $decodedResult->event ?? 'No events found';
            }
        }
        return 'No events found';
    }
}
