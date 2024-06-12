<?php

declare(strict_types=1);

namespace App\Application\Queue;

class MessageDTO
{
    public function __construct(
        public string $uuid,
        public string $description,
    ) {
    }

    public static function buildFromArray(array $rawData): static
    {
        return new MessageDTO(
            $rawData['uuid'] ?? null,
            $rawData['description'] ?? null,
        );
    }

    public static function buildFromJSONString(string $jsonData): static
    {
        return static::buildFromArray(json_decode($jsonData, true));
    }

    public function jsonSerialize(): mixed
    {
        return [
            'uuid' => $this->uuid,
            'description' => $this->description,
        ];
    }

    public function __toString(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }
}
