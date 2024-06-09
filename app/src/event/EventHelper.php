<?php

declare(strict_types=1);

namespace Dsergei\Hw12\event;

use Dsergei\Hw12\console\ConsoleParameters;

class EventHelper
{
    public function checkConditions(Event $event, ConsoleParameters $arg): bool
    {
        $countUserRequestParams = count($arg->params);
        $counter = 0;
        foreach ($arg->params as $param => $value) {
            if (isset($event->conditions[$param]) && $event->conditions[$param] === $value) {
                $counter++;
            }
        }

        return $counter === $countUserRequestParams;
    }
}
