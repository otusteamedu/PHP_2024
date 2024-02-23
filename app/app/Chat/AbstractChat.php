<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Chat;

use Exception;
use Rmulyukov\Hw5\Socket\UnixSocket;

abstract class AbstractChat
{
    protected UnixSocket $socket;

    /**
     * @throws Exception
     */
    public function __construct(string $socketPath)
    {
        $this->socket = new UnixSocket($socketPath);
    }

    abstract public function run(): void;
}
