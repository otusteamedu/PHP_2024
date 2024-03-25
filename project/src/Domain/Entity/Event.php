<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Entity;

use JsonSerializable;

class Event implements JsonSerializable
{
    private int $priority;
    private string $condition;
    private string $payload;

    public function __construct(int $priority, string $condition, string $payload)
    {
        $this->priority = $priority;
        $this->condition = $condition;
        $this->payload = $payload;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public static function fromJson(string $json): Event
    {
        $input = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return new Event(
            $input['priority'],
            $input['condition'],
            $input['payload'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'priority' => $this->priority,
            'condition' => $this->condition,
            'payload' => $this->payload,
        ];
    }
}
