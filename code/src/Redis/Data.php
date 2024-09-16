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
        $event = $this->config->params;
        if (!$event['key'] || !$event['value']) {
            throw new Exception('ERROR: No data specified. Set `key` and `value` args.');
        }
        $this->redis->set($event['key'], $event['value']);
    }

    public function clearAll()
    {
        $this->redis->flushdb();
    }

    public function getEvent()
    {
        $query = $this->config->params;
        if (!$query['key']) {
            throw new Exception('ERROR: No data specified. Set `key` arg.');
        }
        $data = $this->redis->get($query['key']);
        print_r($data);
    }


}
