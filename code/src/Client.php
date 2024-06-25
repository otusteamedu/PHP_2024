<?php

declare(strict_types=1);

namespace Otus\Chat;

class Client
{
    public function run()
    {
        $socket = new Socket();
        $socket->init();

        while (1) {
            $msg = readline('Your message: ');
            $socket->send($msg);
            $socket->receive();

            if ($msg === '/exit') {
                break;
            }
        }

        $socket->close();
    }
}
