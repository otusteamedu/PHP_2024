<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

#[ORM\Embeddable]
class Title
{
    #[ORM\Column(type: 'string')]
    private string $title;

    public function __construct(string $title)
    {
        $this->ensureIsValidTitle($title);
        $this->title = $title;
    }

    public function getValue(): string
    {
        return $this->title;
    }

    private function ensureIsValidTitle(string $title): void
    {
        if (empty($title)) {
            throw new InvalidArgumentException('Title cannot be empty.');
        }

        if (mb_strlen($title) > 255) {
            throw new InvalidArgumentException('Title cannot be longer than 255 characters.');
        }
    }
}
