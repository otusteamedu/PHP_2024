<?php

declare(strict_types=1);

namespace App\Services\Connectors;

use App\Contracts\ConnectorInterface;
use Predis\Client;
use Predis\Response\Status;

class RedisConnector implements ConnectorInterface
{
    public Client $client;

    public function __construct(array $params)
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host' => $params['host'],
            'port' =>$params['port'],
            'password' => $params['password']
        ]);

    }

    public function search(string $key): mixed
    {
        return json_decode($this->client->get($key));
    }

    public function update(string $key, mixed $value): Status
    {
        return $this->client->set($key, json_encode($value));
    }

    public function setKey(string $key, mixed $value): Status
    {
        return $this->client->set($key, json_encode($value));
    }

    public function dropKey(string $key): int
    {
        return $this->client->del($key);
    }

    public function getAll(): array
    {
        $keys = $this->client->keys('event:*');
        $values = [];

        foreach ($keys as $key) {
            $values[] = json_decode($this->client->get($key), true);
        }

        return $values;
    }

    public function clear(): mixed
    {
        return $this->client->flushall();
    }
}
