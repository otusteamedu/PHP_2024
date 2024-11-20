<?php

declare(strict_types=1);

namespace hw15\helpers;

use hw15\entities\ConditionEntity;
use hw15\entities\EventEntity;

class SearchHelper
{
    public function findByConditions(ConditionEntity $conditionEntity, array $events): string
    {
        $suitableEvent = [];

        foreach ($events as $event) {
            if ($this->check($conditionEntity, $event)) {
                $suitableEvent = $event;
                break;
            }
        }

        return json_encode($suitableEvent);
    }

    private function check(ConditionEntity $conditionEntity, EventEntity $eventEntity)
    {
        $params = $conditionEntity->params;
        $countUserRequestParams = count($params);
        $counter = 0;

        foreach ($params as $param => $value) {
            if (isset($eventEntity->conditions[$param]) && $eventEntity->conditions[$param] === $value) {
                $counter++;
            }
        }

        return $counter === $countUserRequestParams;
    }
}
