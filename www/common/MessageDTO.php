<?php

declare(strict_types=1);

namespace Common;

readonly class MessageDTO implements \JsonSerializable
{
    public function __construct(
        public ?string $message,
        public ?string $email,
        public ?string $user,
        public bool $notify,
    ) {
    }

    public static function buildFromArray(array $rawData): static
    {
        return new MessageDTO(
            $rawData['message'] ?? null,
            $rawData['email'] ?? null,
            $rawData['user'] ?? null,
            $rawData['notify'] ?? false,
        );
    }

    public static function buildFromJSONString(string $jsonData): static
    {
        return static::buildFromArray(json_decode($jsonData, true));
    }

    public function jsonSerialize(): mixed
    {
        return [
            'email' => $this->email,
            'message' => $this->message,
            'user' => $this->user,
            'notify' => $this->notify,
        ];
    }

    public function __toString(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }
}
