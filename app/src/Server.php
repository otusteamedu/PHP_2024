<?php

declare(strict_types=1);

namespace Kagirova\Hw5;

use Kagirova\Hw5\UnixSocket;

class Server
{
    private UnixSocket $socket;

    public function __construct()
    {
        $this->socket = new UnixSocket();
    }

    public function run()
    {
        $this->socket->create(true);
        $this->socket->bind();
        $this->socket->listen();

        while (true) {
            try {
                $connection = $this->socket->accept();
            } catch (\Exception $e) {
                echo $e;
                break;
            }

            while (true) {
                $message = $this->socket->read($connection);
                if (!$message = trim($message)) {
                    continue;
                }
                if ($message == 'quit') {
                    break;
                }
                if ($message == 'shutdown') {
                    $this->socket->close();
                    break;
                }
                echo 'Server got a message: ' . $message;
                $this->socket->write('Server received ' . strlen($message) . " bytes\n", $connection);
            }
        }
        $this->socket->close();

    }
}