<?php

namespace Otus\App\Redis;

use Exception;
use RedisException;

class Data
{
    private Entry $client;
    private array $argv;

    public function __construct()
    {
        $this->client = new Entry();
        $this->argv = $this->client->config->argv;
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function newEvent(): void
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

    /**
     * @throws RedisException
     */
    public function clearAll(): void
    {
        $result = $this->client->clear();
        $this->output($result);
    }

    /**
     * @return void
     * @throws RedisException
     */
    public function getEvent(): void
    {
        $searchParams = isset($this->argv[2])
            ? $this->getPropData($this->argv[2], 'params')
            : '';

        $result = $this->client->get($searchParams);
        $this->output($result);
    }

    /**
     * @param string $subject
     * @param string $propName
     * @return string
     */
    private static function getPropData(string $subject, string $propName): string
    {
        $pattern = sprintf('/%s:\s*{?\s*(\d+|[^}]+?(?=\s*}))/', $propName);
        preg_match($pattern, $subject, $matches);
        return $matches[1];
    }

    /**
     * @param $data
     * @return void
     */
    private static function output($data): void
    {
        echo PHP_EOL;
        print_r($data);
        echo PHP_EOL;
    }
}
