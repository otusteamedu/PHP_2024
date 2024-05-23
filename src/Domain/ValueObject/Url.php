<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Url
{
    #[ORM\Column(type: 'string')]
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getValue(): string
    {
        return $this->url;
    }
}
