<?php

namespace Otus\App\Redis;

use Exception;

class Data
{
    private Entry $client;
    private array $argv;

    public function __construct()
    {
        $this->client = new Entry();
        $this->argv = $this->client->config->argv;
    }

    public function newEvent()
    {
        if (!isset($this->argv[2])) {
            throw new Exception('ERROR: No event data specified.');
        }
        $query = $this->argv[2];
        $priority = $this->getPropData($query, 'priority');
        $conditions = $this->getPropData($query, 'conditions');
        $event = $this->getPropData($query, 'event');

        $result = $this->client->add($priority, $conditions, $event);
        $this->output($result);
    }

    public function clearAll()
    {
        $result = $this->client->clear();
        $this->output($result);
    }

    public function getEvent()
    {
        $searchParams = isset($this->argv[2])
            ? $this->getPropData($this->argv[2], 'params')
            : '';

        $result = $this->client->get($searchParams);
        $this->output($result);
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
