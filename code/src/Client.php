<?php

declare(strict_types=1);

namespace Otus\Chat;

class Client extends Controller
{
    public function run()
    {
        $socket = new Socket();
        $socket->init($this->clientPath);

        while (1) {
            $msg = readline('> You: ');
            $socket->send($msg, $this->serverPath);

            $data = $socket->receive();
            if ($data) {
                echo '> Responce: ' . $data . "\n";
            }

            if ($msg === '/exit') {
                break;
            }
        }

        $socket->close($this->clientPath);
    }
}
