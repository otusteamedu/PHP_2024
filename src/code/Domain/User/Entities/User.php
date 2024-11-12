<?php

declare(strict_types=1);

namespace Domain\User\Entities;

class User
{
    private int $id;
    private string $telegramChatId;

    public function __construct(int $id, string $telegramChatId)
    {
        $this->id = $id;
        $this->telegramChatId = $telegramChatId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTelegramChatId(): string
    {
        return $this->telegramChatId;
    }

    public function equals(User $other): bool
    {
        return $this->id === $other->id &&
            $this->telegramChatId === $other->telegramChatId;
    }
}
