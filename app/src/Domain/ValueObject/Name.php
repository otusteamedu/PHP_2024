<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Name
{
    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidName($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function assertValidName(string $value): void
    {
        if ('' === $value) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        if (mb_strlen($value) > 255) {
            throw new \InvalidArgumentException('Name cannot be longer than 255 characters');
        }
    }
}
