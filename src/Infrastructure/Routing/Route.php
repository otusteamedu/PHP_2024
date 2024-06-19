<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Routing;

final class Route
{
    public function __construct(
        private readonly string $path,
        private readonly string $method,
        private readonly object $handler
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHandler(): object
    {
        return $this->handler;
    }
}
