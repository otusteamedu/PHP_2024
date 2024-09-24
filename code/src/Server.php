<?php

declare(strict_types=1);

namespace Otus\Chat;

use Exception;

class Server
{
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct(string $socketPath)
    {
        $this->socket = new Socket($socketPath);
    }

    /**
     * @throws Exception
     */
    public function run(): void
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

            echo 'Received message: \'' . $data . "'\n";
            $this->socket->send(mb_strlen($data, '8bit') . ' bytes received.', $accept);

            if ($data === '/exit') {
                echo "Server is aborting\n";
                break;
            }
        }

        $this->socket->close();
    }
}