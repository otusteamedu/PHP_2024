<?php

declare(strict_types=1);

namespace Otus\Chat;

class Server
{
    private Socket $socket;
    public function __construct(string $socketPath)
    {
        $this->socket = new Socket($socketPath);
    }

    public function run()
    {
        $this->socket->bind();
        $this->socket->listen();
        echo "Server is ready\n";
        $accept = $this->socket->accept();

        while (1) {
            $data = $this->socket->read($accept);
            if (!$data) {
                continue;
            }

            echo 'Recieved message: \'' . $data . "'\n";
            $this->socket->send(mb_strlen($data, '8bit') . ' bytes recieved.', $accept);

            if ($data === '/exit') {
                echo "Server is aborting\n";
                break;
            }
        }

        $this->socket->close();
    }
}
