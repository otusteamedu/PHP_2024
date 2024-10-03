<?php

declare(strict_types=1);

namespace Evgenyart\Hw12;

use Exception;

class MatchHelper
{
    public static function matchResult($searchData, $eventsData): array
    {
        foreach ($eventsData as $event) {
            $goodEvent = true;
            $eventDecode = json_decode($event, true);

            foreach ($searchData['params'] as $key => $value) {
                if (!isset($eventDecode['conditions'][$key])) {
                    $goodEvent = false;
                    break;
                }
                if ($eventDecode['conditions'][$key] <> $value) {
                    $goodEvent = false;
                    break;
                }
            }

            if ($goodEvent) {
                return $eventDecode;
            }
        }

        return [];
    }
}
