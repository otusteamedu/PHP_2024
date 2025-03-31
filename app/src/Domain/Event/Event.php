<?php

declare(strict_types=1);

namespace Aware\App\Domain\Event;

readonly class Event
{
    public function __construct(
        public int $priority,
        public array $conditions,
        public array $event
    ) {
    }

    public static function decode(string $json): Event
    {
        $data = json_decode($json, true);

        return new Event($data['priority'], $data['conditions'], $data['event']);
    }

    public function hasAllConditions($conditions): bool
    {
        $countConditions = count($conditions);
        $countEventHasConditions = 0;

        foreach ($conditions as $conditionKey => $conditionValue) {
            if (!isset($this->conditions[$conditionKey])) {
                continue;
            }

            if ($this->conditions[$conditionKey] === $conditionValue) {
                $countEventHasConditions++;
            }
        }

        if ($countEventHasConditions === $countConditions) {
            return true;
        }
        if (($countEventHasConditions < $countConditions) && ($countEventHasConditions === count($this->conditions))) {
            return true;
        }

        return false;
    }

    public function isBetterThanLast(?Event $otherEvent): bool
    {
        if (is_null($otherEvent)) {
            return true;
        }

        return $otherEvent->priority < $this->priority;
    }
}
