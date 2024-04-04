<?php

declare(strict_types=1);

namespace Afilipov\Hw13;

class Review
{
    private ?int $id = null;

    public function __construct(public readonly string $text)
    {
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
