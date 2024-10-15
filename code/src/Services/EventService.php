<?php

declare(strict_types=1);

namespace Otus\App\Services;

use Exception;
use Otus\App\Config\Config;
use Otus\App\Storage\Redis\RedisStorage;
use Otus\App\Storage\StorageInterface;
use RedisException;

class EventService
{
    private ?string $query;
    private string $sortedSetName;
    private Config $config;
    private StorageInterface $storage;

    public function __construct()
    {
        $this->config = new Config();
        $this->storage = new RedisStorage($this->config->host, $this->config->port);

        $this->query = $this->config->query;
        $this->sortedSetName = $this->config->sortedSetName;
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function newEvent(): void
    {
        if (!isset($this->query)) {
            throw new Exception('ERROR: No event data specified.');
        }

        $priority = $this->getQueryPropData('priority');
        $conditions = $this->getQueryPropData('conditions');
        $event = $this->getQueryPropData('event');

        $result = $this->storage->add(
            $this->sortedSetName,
            $priority,
            json_encode([
                'priority' => $priority,
                'conditions' => $conditions,
                'event' => $event
            ]));

        $this->output($result);
    }

    /**
     * @throws RedisException
     */
    public function clearAll(): void
    {
        $result = $this->storage->clear($this->sortedSetName);
        $this->output($result);
    }

    /**
     * @return void
     * @throws RedisException
     */
    public function getEvent(): void
    {
        $searchParams = isset($this->query) ? $this->getQueryPropData('params') : '';

        $result = $this->storage->get($this->sortedSetName, $searchParams);
        $this->output($result);
    }

    /**
     * @param string $propName
     * @return string
     */
    private function getQueryPropData(string $propName): string
    {
        $pattern = sprintf('/%s:\s*{?\s*(\d+|[^}]+?(?=\s*}))/', $propName);
        preg_match($pattern, $this->query, $matches);
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
