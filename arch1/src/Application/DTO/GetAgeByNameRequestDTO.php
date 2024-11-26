<?php

namespace App\Application\DTO;

use App\Application\Contracts\DTO\GetNameInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GetAgeByNameRequestDTO implements GetNameInterface
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }
}
