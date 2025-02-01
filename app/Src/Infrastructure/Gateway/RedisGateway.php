<?php

namespace Src\Infrastructure\Gateway;

use Exception;
use Src\Application\Gateway\RedisGatewayInterface;

class RedisGateway implements RedisGatewayInterface
{
    private static \Predis\Client $Client;

    public function __construct()
    {
        self::$Client = new \Predis\Client(['host' => getenv('REDIS_HOST'), 'port' => getenv('REDIS_PORT')]);
    }

    public function setStatus(string $id, int $status): void
    {
        self::$Client->executeRaw(["SET", "requests:$id", $status], $error);
        if (false !== $error) {
            throw new Exception('Error add requests');
        }
    }

    public function getStatus(string $id): ?int
    {
        $res = self::$Client->executeRaw(["GET", "requests:$id"], $error);
        if (false !== $error) {
            throw new Exception('Error get requests');
        }
        return $res;
    }

    public function saveResult(string $id, array $result): void
    {
        self::$Client->executeRaw(["SET", "result:$id", json_encode($result)], $error);
        if (false !== $error) {
            throw new Exception('Error save result');
        }
    }

    public function getResult(string $id): ?array
    {
        $res = self::$Client->executeRaw(["GET", "result:$id"], $error);
        if (false !== $error) {
            throw new Exception('Error get result');
        }
        return json_decode($res, true);
    }
}