<?php

declare(strict_types=1);

namespace Otus\Chat;

class Client
{
    public function run()
    {
        $socket = new Socket();
        $socket->init($socket->clientPath);

        while (1) {
            $msg = readline('> You: ');
            $socket->send($msg, $socket->serverPath);

            $data = $socket->receive();
            if ($data) echo '> Responce: ' . $data . "\n";

            if ($msg === '/exit') break;
        }

        $socket->close($socket->clientPath);
    }
}
