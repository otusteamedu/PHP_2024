<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
class Url
{
    #[Assert\NotBlank]
    #[Assert\Url]
    #[ORM\Column(name: 'url', type: Types::TEXT, unique: true, nullable: false)]
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
