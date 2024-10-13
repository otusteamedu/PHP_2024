<?php

namespace VladimirGrinko\Redis;

class Get
{
    public function getEvent(array $arParams): ?string
    {
        $conObj = new Connect();
        $redis = $conObj->getRedis();

        $keys = [];
        foreach ($arParams as $param => $value) {
            $keys[] = Connect::PARAMS . ':' . $param . ':' . $value;
        }

        $arEvents = $redis->sInter($keys);
        if (empty($arEvents)) {
            return null;
        }

        $arWeights = $redis->hMGet(Connect::WEIGHTS, $arEvents);
        arsort($arWeights);

        foreach ($arWeights as $eId => $weight) {
            if (($event = $redis->hGet(Connect::ALL_EVENTS, $eId)) !== false) {
                return $event;
            }
        }

        return null;
    }
}
