<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Domain\Entity;

use DateTimeInterface;

final class Post
{
    public function __construct(
        public ?int $id,
        public string $title,
        public DateTimeInterface $date,
        public string $url,
    ) {}

    public static function make(string $title, DateTimeInterface $date, string $url): self
    {
        return new self(null, $title, $date, $url);
    }
}
