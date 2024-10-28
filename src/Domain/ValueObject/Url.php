<?php

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Url
{
    private const HTTP = 'https://';

    private const MIN_LENGTH = 12;

    #[ORM\Column(type: 'string', length: 300,  unique: true, nullable: false)]
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidUrl($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidUrl(string $value): void
    {
        if (!str_contains($value, self::HTTP)) {
            throw new \InvalidArgumentException('Url is not valid');
        }

        if (mb_strlen($value) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException('Url must be at least 12 characters long');
        }
    }
}
