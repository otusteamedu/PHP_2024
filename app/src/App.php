<?php

namespace Kagirova\Hw15;

class App
{
    private RedisStorage $redisStorage;

    public function __construct()
    {
        $this->redisStorage = new RedisStorage();
    }

    public function run($args)
    {
        if (empty($args[1])) {
            throw new \Exception('Must have an argument');
        }
        $options = getopt('f:p:c:e:');

        switch ($options['f']) {
            case 'get':
                $this->get($options);
                break;
            case 'set':
                $this->set($options);
                break;
            case 'clear':
                $this->clear();
                break;
            default:
                throw new \Exception('Must have a function');
        }
    }

    private function clear()
    {
        $this->redisStorage->clear();
    }

    private function get($options)
    {
        $conditions = [];
        if (!empty($options['c'])) {
            $conditions['conditions'] = json_decode($options['c'], true);
        }
        $event = $this->redisStorage->get($conditions);
        if (!(isset($event))) {
            throw new \Exception('Event not found');
        }
        $event->print();
    }

    private function set($options)
    {
        $priority = 0;
        $conditions = [];
        $name = '';
        if (!empty($options['p'])) {
            $priority = $options['p'];
        }
        if (!empty($options['c'])) {
            $conditions = json_decode($options['c'], true);
        }
        if (!empty($options['e'])) {
            $name = $options['e'];
        }
        $event = new Event($priority, $conditions, $name);
        $this->redisStorage->set($event);
    }
}
