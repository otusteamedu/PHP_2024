<?php

declare(strict_types=1);

namespace Otus\Chat;

class Server
{
    public function run()
    {
        $socket = new Socket();
        $socket->init();

        while (1) {
            $data = $socket->receive();
            $socket->send($data);

            if ($data === '/exit') {
                break;
            }
        }

        $socket->close();
    }
}
