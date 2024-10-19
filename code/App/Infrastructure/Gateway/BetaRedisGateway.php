<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\RedisGatewayInterface;
use App\Application\Gateway\RedisGatewayRequest;
use App\Application\Gateway\RedisGatewayResponse;
use Exception;

class BetaRedisGateway implements RedisGatewayInterface
{
    private static \Predis\Client $Client;

    public function __construct()
    {
        self::$Client = new \Predis\Client(['host' => $_ENV['REDIS_HOST'], 'port' => $_ENV['REDIS_PORT']]);
    }
    public function saveEvent(RedisGatewayRequest $request): RedisGatewayResponse
    {
        $id = $this->getTotal();
        $id++;
        $priority = self::$Client->executeRaw(["GET", "priority:{$request->event->getPriority()->getValue()}"], $error);
        if (false !== $error) {
            throw new Exception('Error get priority: ' . $error);
        }

        if (!empty($priority) && (int)$priority === 1) {
            throw new Exception("Priority {$request->event->getPriority()->getValue()} exists");
        }

        self::$Client->executeRaw(["ZADD", "priority", $request->event->getPriority()->getValue(), $id], $error);
        if (false !== $error) {
            throw new Exception('Error priority event: ' . $error);
        }

        self::$Client->executeRaw(["SET", "priority:{$request->event->getPriority()->getValue()}", 1], $error);
        if (false !== $error) {
            throw new Exception('Error set priority in list: ' . $error);
        }

        foreach ($request->event->getConditionList()->getConditionList() AS $key => $value) {
            self::$Client->executeRaw(["RPUSH", "$key:$value", $id], $error);
            if (false !== $error) {
                throw new Exception('Error condition event: ' . $error);
            }
        }

        self::$Client->executeRaw(["SET", "params:$id", json_encode(array_keys($request->event->getConditionList()->getConditionList()))], $error);
        if (false !== $error) {
            throw new Exception('Error event event: ' . $error);
        }

        self::$Client->executeRaw(["SET", "events:$id", $request->event->getName()->getValue()], $error);
        if (false !== $error) {
            throw new Exception('Error event event: ' . $error);
        }
        return new RedisGatewayResponse($id);
    }
    private function getTotal()
    {
        $total = self::$Client->executeRaw(["ZCARD", "priority"], $error);
        if (false !== $error) {
            throw new Exception('Error get total items: ' . $error);
        }
        return $total;
    }

    public function clear()
    {
        self::$Client->executeRaw(["FLUSHDB"], $error);
        if (false !== $error) {
            throw new Exception('Error clear events');
        }
    }

    public function search(array $params)
    {
        $helper = $finds = [];

        $total_items = $this->getTotal();

        $count_params = count($params);

        foreach ($params AS $key => $value) {
            $finds[$key] = self::$Client->executeRaw(["LRANGE", "$key:$value", 0, $total_items], $error);
            if (false !== $error) {
                throw new Exception('Error find condition: ' . $error);
            }
            foreach ($finds[$key] AS $k => $v) {
                $helper[$v][$key] = $k;
            }
        }

        $full_find = array_filter($helper, fn($t) => count($t) === $count_params) ?? [];

        foreach ($helper AS $key => $value) {
            if (in_array($key, array_keys($full_find))) continue;

            $search = self::$Client->executeRaw(["GET", "params:$key"], $error);
            if (false !== $error || empty($search)) {
                throw new Exception('Error get another params: ' . $error);
            }
            $search = json_decode($search, true);
            if (empty(array_diff($search, array_keys($value)))) {
                $full_find[$key] = $value;
            }
        }

        $max = null;
        $priorities = [];
        foreach (array_keys($full_find) AS $value) {
            $priority = self::$Client->executeRaw(["ZRANK", "priority", $value], $error);
            if (false !== $error) {
                throw new Exception('Error get priority: ' . $error);
            }
            $priorities[$priority] = $value;
            $max = max($priority, $max);
        }

        if ($priorities[$max]) {
            echo "Find: ".$priorities[$max];
        } else {
            echo "Event not found";
        }
    }
}