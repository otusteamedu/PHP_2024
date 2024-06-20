<?php

declare(strict_types=1);

namespace Orlov\Otus\Connection;

interface ConnectionInterface
{
    public function getClient();
    public function close(): void;
}
