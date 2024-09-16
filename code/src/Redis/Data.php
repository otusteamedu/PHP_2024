<?php

namespace Otus\App\Redis;

use Exception;

class Data
{
    private \Redis $redis;
    private Config $config;

    public function __construct()
    {
        $entry = new Entry();
        $this->config = $entry->config;
        $this->redis = $entry->redis;
    }

    public function newEvent()
    {
        if (!isset($this->config->argv[2])) {
            throw new Exception('ERROR: No event data specified.');
        }
        $query = $this->config->argv[2];
        $priority = $this->getPropData($query, 'priority');
        $conditions = $this->getPropData($query, 'conditions');
        $event = $this->getPropData($query, 'event');

        $result = $this->redis->zAdd('events', $priority, json_encode([
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event
        ]));
        $this->output($result);
    }

    public function clearAll()
    {
        $result = $this->redis->del('events');
        $this->output($result);
    }

    public function getEvent()
    {
        $position = 0;
        $eventsLength = $this->redis->zCard('events');
        $searchParams = isset($this->config->argv[2])
            ? $this->getPropData($this->config->argv[2], 'params')
            : '';
        while ($position < $eventsLength) {
            $result = $this->redis->zRevRangeByScore('events', '+inf', '-inf', ['limit' => [$position++, 1]])[0];
            if (!$result) {
                continue;
            }
            $decodedResult = json_decode($result);
            if ($decodedResult && (!isset($decodedResult->conditions) || $decodedResult->conditions === $searchParams)) {
                $this->output($decodedResult->event ?? 'No events found');
                return;
            }
        }
        $this->output('No events found');
    }

    private static function getPropData(string $subject, string $propName)
    {
        $pattern = sprintf('/%s:\s*{?\s*(\d+|[^}]+?(?=\s*}))/', $propName);
        preg_match($pattern, $subject, $matches);
        return $matches[1];
    }

    private static function output($data)
    {
        echo PHP_EOL;
        print_r($data);
        echo PHP_EOL;
    }
}
