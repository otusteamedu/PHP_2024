<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

class EventHelper
{
    public function checkConditions(Event $event, UserRequest $userRequest): bool
    {
        $countUserRequestParams = count($userRequest->params);
        $counter = 0;
        foreach ($userRequest->params as $param => $value) {
            if (isset($event->conditions[$param]) && $event->conditions[$param] === $value) {
                $counter++;
            }
        }

        return $counter === $countUserRequestParams;
    }
}
