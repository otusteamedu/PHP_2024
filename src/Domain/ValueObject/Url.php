<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

#[ORM\Embeddable]
class Url
{
    #[ORM\Column(type: 'string')]
    private string $url;

    public function __construct(string $url)
    {
        $this->ensureIsValidUrl($url);
        $this->url = $url;
    }

    public function getValue(): string
    {
        return $this->url;
    }

    private function ensureIsValidUrl(string $url): void
    {
        if (empty($url)) {
            throw new InvalidArgumentException('Url cannot be empty.');
        }

        if (mb_strlen($url) > 255) {
            throw new InvalidArgumentException('Url cannot be longer than 255 characters.');
        }
    }
}
