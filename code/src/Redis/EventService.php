<?php

declare(strict_types=1);

namespace OtusRedis\App\Redis;

use Exception;
use Predis\PredisException;

class EventService
{
    private ?string $query;
    private string $sortedSetName;
    private Config $config;
    private RedisStorage $storage;

    public function __construct()
    {
        $this->config = new Config();
        $this->storage = new RedisStorage($this->config->host, $this->config->port);
        $this->query = $this->config->query;
        $this->sortedSetName = $this->config->sortedSetName;
    }

    /**
     * @throws PredisException
     * @throws Exception
     */
    public function newEvent(): void
    {
        if (!isset($this->query)) {
            throw new Exception('ERROR: No' . $this->sortedSetName . ' data specified.');
        }

        $priority = $this->getQueryPropData('priority');
        $conditions = $this->getQueryPropData('conditions');
        $event = $this->getQueryPropData('event');

        $result = $this->storage->add(
            $this->sortedSetName,
            [json_encode(['priority' => $priority, 'conditions' => $conditions, 'event' => $event]) => $priority]
        );

        $this->output($result);
    }

    /**
     * @return void
     */
    public function clearAll(): void
    {
        $result = $this->storage->clear($this->sortedSetName);
        $this->output($result);
    }

    /**
     * @return void
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
