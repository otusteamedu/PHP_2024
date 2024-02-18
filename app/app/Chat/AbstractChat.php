<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Chat;

use Exception;
use Rmulyukov\Hw5\Socket\UnixSocket;

abstract readonly class AbstractChat
{
    protected UnixSocket $socket;

    /**
     * @throws Exception
     */
    public function __construct(string $fileName)
    {
        $this->socket = new UnixSocket($this->prepareSocketFilePath($fileName));
    }

    abstract public function run(): void;

    protected function prepareSocketFilePath(string $fileName): string
    {
        return __DIR__ . '/../../../storage/' . $fileName;
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->socket->removeFile();
    }
}
