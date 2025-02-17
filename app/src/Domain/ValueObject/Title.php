<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Domain\ValueObject;

class Title
{
    private string $title;

    public function __construct(string $title)
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('Title cannot be empty');
        }
        $this->title = $title;
    }

    public function getValue(): string
    {
        return $this->title;
    }
}
