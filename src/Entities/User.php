<?php

declare(strict_types=1);

namespace Amikha1lov\DataMapper\Entities;

use Amikha1lov\DataMapper\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class User implements Entity
{
    public function __construct(
        private int $id,
        #[Assert\NotBlank]
        private string $name,
        #[Assert\Positive]
        private int $age,
    ) {
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
