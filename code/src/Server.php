<?php

declare(strict_types=1);

namespace Otus\Chat;

class Server extends Controller
{
    public function run()
    {
        $socket = new Socket();
        $socket->init($this->serverPath);
        echo "Server is ready\n";

        while (1) {
            $data = $socket->receive();
            if ($data) {
                echo 'Recieved message: ' . $data . "\n";
            }

            $socket->send(mb_strlen($data, '8bit') . ' bytes recieved.', $this->clientPath);

            if ($data === '/exit') {
                break;
            }
        }

        $socket->close($this->serverPath);
    }
}
