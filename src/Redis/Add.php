<?php

namespace VladimirGrinko\Redis;

class Add
{
    public function add(string $event, int $priority, array $arParams)
    {
        $conObj = new Connect();
        $redis = $conObj->getRedis();

        $eId = $this->getId($redis);

        $this->addEvent($redis, $event, $eId);

        $this->addWeight($redis, $priority, $eId);

        $this->addParams($redis, $arParams, $eId);
    }

    private function getId($redis): int
    {
        return $redis->incr(Connect::COUNTER);
    }

    private function addEvent($redis, string $event, int $eId): void
    {
        if ($redis->hSet(Connect::ALL_EVENTS, $eId, $event) === false) {
            throw new \Exception("Не удалось добавить событие");
        }
    }

    private function addWeight($redis, int $priority, int $eId): void
    {
        if ($redis->hSet(Connect::WEIGHTS, $eId, $priority) === false) {
            throw new \Exception("Не удалось добавить приоритет события во множество");
        }
    }

    private function addParams($redis, array $arParams, int $eId): void
    {
        foreach ($arParams as $key => $value) {
            if ($redis->sAdd(Connect::PARAMS . ':' . $key . ':' . $value, $eId) <= 0) {
                throw new \Exception("Не удалось добавить параметр");
            }
        }
    }
}
