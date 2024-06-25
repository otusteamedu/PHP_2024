<?php

declare(strict_types=1);

namespace Otus\Chat;

class Server
{
    public function run()
    {
        $socket = new Socket();
        $socket->init($socket->serverPath);
        echo "Server is ready\n";

        while (1) {
            $data = $socket->receive();
            if ($data) {
                echo 'Recieved message: ' . $data . "\n";
            }

            $socket->send(mb_strlen($data, '8bit') . ' bytes recieved.', $socket->clientPath);

            if ($data === '/exit') {
                break;
            }
        }

        $socket->close($socket->serverPath);
    }
}
