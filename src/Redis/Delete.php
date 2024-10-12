<?php

namespace VladimirGrinko\Redis; 

class Delete
{
    public function del(): void
    {
        $conObj = new Connect();
        $redis = $conObj->getRedis();

        $res = $redis->del(Connect::ALL_EVENTS, Connect::WEIGHTS);

        if ($res !== 2) {
            if ($redis->exists(Connect::ALL_EVENTS) === 1) {
                throw new \Exception("Не удалось удалить события");
            }
            if ($redis->exists(Connect::WEIGHTS) === 1) {
                throw new \Exception("Не удалось удалить приоритеты событий");
            }
        }
    }
}