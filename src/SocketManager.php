<?php

declare(strict_types=1);

namespace Alogachev\Homework;

class SocketManager
{
    public function __construct(
        private readonly string $socketPath,
    ) {
    }
}
