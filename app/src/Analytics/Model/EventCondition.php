<?php

declare(strict_types=1);

namespace App\Analytics\Model;

final readonly class EventCondition
{
    public function __construct(
        public string $key,
        public string $value,
    ) {}

    public function matches(EventCondition $condition): bool
    {
        return $condition->key === $this->key
            && $condition->value === $this->value;
    }

    /**
     * @return array{key: string, value: string}
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toString(): string
    {
        return sprintf('%s: %s', $this->key, $this->value);
    }
}
