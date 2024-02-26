<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\DTO\Socket;

use Kiryao\Sockchat\Helpers\DTO\DTOInterface;

class Config implements DTOInterface
{
    public function __construct(
        private int $length,
        private int $domain,
        private int $type,
        private int $protocol,
        private int $port,
        private int $backlog,
        private int $flags,
    ) {
    }

    public function getMaxLength(): int
    {
        return $this->length;
    }

    public function getDomain(): int
    {
        return $this->domain;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getProtocol(): int
    {
        return $this->protocol;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getBacklog(): int
    {
        return $this->backlog;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }
}
