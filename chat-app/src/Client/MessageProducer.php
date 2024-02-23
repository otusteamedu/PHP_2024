<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Client;

use RuntimeException;
use Sfadeev\ChatApp\Socket\UnixSocket;

class MessageProducer
{
    private UnixSocket $socket;

    /**
     * @param UnixSocket $socket
     */
    public function __construct(UnixSocket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * @param string $msg
     * @return void
     *
     * @throws RuntimeException
     */
    public function send(string $msg): void
    {
        $this->socket->send($msg);
    }
}
