<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp\Server;

use Sfadeev\ChatApp\Socket\UnixSocket;

class MessageConsumer
{
    private UnixSocket $inputSocket;

    /**
     * @param UnixSocket $inputSocket
     */
    public function __construct(UnixSocket $inputSocket)
    {
        $this->inputSocket = $inputSocket;
    }

    /**
     * @param int $msgLength
     * @return string
     */
    public function consume(int $msgLength): string
    {
        return $this->inputSocket->read($msgLength);
    }
}
