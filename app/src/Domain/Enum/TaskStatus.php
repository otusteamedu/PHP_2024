<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum TaskStatus: string
{
    case QUEUED = 'queued';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getTitle(): string
    {
        return match ($this) {
            self::QUEUED => 'В очереди',
            self::PROCESSING => 'Обрабатывается',
            self::COMPLETED => 'Обработана',
        };
    }
}
