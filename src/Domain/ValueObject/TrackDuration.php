<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class TrackDuration implements IGetFormatedDuration
{
    private int $value;

    public function __construct(
        int $value
    ) {
        $this->setValue($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getFormatedDuration(): string
    {
        return gmdate('i:s', $this->value);
    }

    private function setValue(int $value): void
    {
        $this->assertUrl($value);
        $this->value = $value;
    }

    private function assertUrl(int $value): void
    {
        if (strlen((string)$value) > 60) {
            throw new InvalidArgumentException('Длина трека не должна превышать 11 символов');
        }
    }
}
