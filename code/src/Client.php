<?php

declare(strict_types=1);

namespace Otus\Chat;

class Client
{
    public function run()
    {
        $socket = new Socket();
        $socket->init();

        $msg = "Message";
        $socket->send($msg);
        $socket->receive();

        $socket->close();
    }
}
