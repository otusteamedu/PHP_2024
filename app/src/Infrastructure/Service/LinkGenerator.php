<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Dto\LinkGeneratorDto;
use App\Application\Service\LinkGeneratorInterface;

class LinkGenerator implements LinkGeneratorInterface
{
    public function __construct(private readonly string $host, private readonly string $path)
    {
    }

    public function generate(string $filename): LinkGeneratorDto
    {
        return new LinkGeneratorDto(sprintf('%s/%s/%s', $this->host, $this->path, $filename));
    }
}
