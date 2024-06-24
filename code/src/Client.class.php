<?php

declare(strict_types=1);

namespace Otus\Chat;

class Client
{
    private $socket;

    public function __construct(Socket $socket)
    {
        // $this->socket = $socket->get();
    }
}
