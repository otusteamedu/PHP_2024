<?php

namespace App\Model;

class Event
{
    public int $priority;
    public array $conditions;
    public array $info;

    public static function create(array $data): Event
    {
        return (new Event())
            ->setPriority($data['priority'])
            ->setParams($data['conditions'])
            ->setInfo($data['event'] ?? $data['info']);
    }

    /**
     * @param array $data
     * @return Event[]
     */
    public static function createArray(array $data): array
    {
        $events = [];

        foreach ($data as $item) {
            $events[] = self::create($item);
        }

        return $events;
    }

    public static function decode(string $json): Event
    {
        $data = json_decode($json, true);

        return self::create($data);
    }

    /**
     * @param int $priority
     * @return Event
     */
    public function setPriority(int $priority): Event
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param array $conditions
     * @return Event
     */
    public function setParams(array $conditions): Event
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @param array $info
     * @return Event
     */
    public function setInfo(array $info): Event
    {
        $this->info = $info;
        return $this;
    }

    public function hasAllConditions($conditions): bool
    {
        $countConditions = count($conditions);
        $countEventHasConditions = 0;

        foreach ($conditions as $conditionKey => $conditionValue) {
            if (!isset($this->conditions[$conditionKey])) continue;

            if ($this->conditions[$conditionKey] === $conditionValue) {
                $countEventHasConditions++;
            }
        }

        if ($countEventHasConditions === $countConditions) return true;
        if (($countEventHasConditions < $countConditions) && ($countEventHasConditions === count($this->conditions))) return true;

        return false;
    }

    public function isBetterThanLast(?Event $otherEvent): bool
    {
        if (is_null($otherEvent)) return true;

        return $otherEvent->priority < $this->priority;
    }
}