<?php

declare(strict_types=1);

namespace App\Analytics\Utility;

use App\Analytics\Model\EventCondition;

final readonly class EventConditionFormatter
{
    public function toList(EventCondition ...$conditions): string
    {
        $list = [];

        foreach ($conditions as $condition) {
            $list[] = $condition->toString();
        }

        return implode(PHP_EOL, $list);
    }
}
