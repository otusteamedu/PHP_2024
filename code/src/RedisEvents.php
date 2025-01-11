<?php

namespace Ekonyaeva\Otus;

use Redis;
use RedisException;
use Ekonyaeva\Otus\EventStoreInterface;

class RedisEvents implements EventStoreInterface
{
    private Redis $redis;
    private string $key = 'events';

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    /**
     * @throws RedisException
     */
    public function add(array $param): void
    {
        $priority = $param['priority'] ?? 0;
        $content = ['conditions' => [], 'event' => $param['event'] ?? '', 'priority' => $priority];
        if (is_array($param['conditions'])) {
            $content['conditions'] = $param['conditions'];
        }
        $this->redis->zAdd($this->key, $priority, json_encode($content));
    }

    /**
     * @throws RedisException
     */
    public function clear(): void
    {
        $this->redis->del($this->key);
    }

    /**
     * @throws RedisException
     */
    public function get(array $param): ?array
    {
        $events = $this->redis->zRevRange($this->key, 0, -1);
        return $this->filter($events, $param);
    }

    private function filter(array $events, array $param): ?array
    {
        if (empty($events)) {
            return null;
        }
        if (empty($param)) {
            return json_decode($events[0],true);
        }


        foreach ($events as $event) {
            $event = json_decode($event, true);
            if (is_array($event['conditions'])) {
                $flag = false;
                foreach ($param as $key => $value) {
                    if (isset($event['conditions'][$key]) && $event['conditions'][$key] === $value) {
                        $flag = true;
                    } else {
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    return $event;
                }
            }
        }
        return null;
    }
}