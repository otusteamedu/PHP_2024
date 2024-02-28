<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\DTO\SocketPath;

use Kiryao\Sockchat\Helpers\DTO\DTOInterface;

class Config implements DTOInterface
{
    public function __construct(
        private string $path,
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
