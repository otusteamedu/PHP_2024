<?php

declare(strict_types=1);

namespace Otus\Chat;

class Client
{
    private Socket $socket;
    public function __construct(string $socketPath)
    {
        $this->socket = new Socket($socketPath);
    }

    public function run()
    {
        $this->socket->connect();

        while (1) {
            $msg = readline('> You: ');
            if (!$msg) {
                sleep(1);
                continue;
            }

            $this->socket->send($msg);

            $data = $this->socket->read();
            if ($data) {
                echo '> Responce: ' . $data . "\n";
            }

            if ($msg === '/exit') {
                break;
            }
        }

        $this->socket->close();
    }
}
