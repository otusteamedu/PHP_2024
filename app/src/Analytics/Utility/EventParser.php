<?php

declare(strict_types=1);

namespace App\Analytics\Utility;

final readonly class EventParser
{
    private EventConditionsParser $eventConditionsParser;

    public function __construct()
    {
        $this->eventConditionsParser = new EventConditionsParser();
    }

    /**
     * @param string $input
     *
     * @return array{name: string, priority: float, conditions: array<array-key, array{key: string, value: string}>}
     */
    public function parse(string $input): array
    {
        return [
            'priority' => $this->getEventPriorityFromInput($input),
            'conditions' => $this->eventConditionsParser->parse($input),
            'name' => $this->getEventNameFromInput($input),
        ];
    }

    private function getEventPriorityFromInput(string $input): float
    {
        preg_match('/priority:\s*(\d*)/', $input, $matches);

        return (float) $matches[1];
    }

    private function getEventNameFromInput(string $input): string
    {
        preg_match('/name:\s*(\w*)/', $input, $matches);

        return $matches[1];
    }
}
