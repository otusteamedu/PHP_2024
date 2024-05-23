<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Title
{
    #[ORM\Column(type: 'string')]
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getValue(): string
    {
        return $this->title;
    }
}
