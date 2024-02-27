<?php

declare(strict_types=1);

namespace Kagirova\Hw5;

use Kagirova\Hw5\UnixSocket;

class Client
{
    private UnixSocket $socket;

    public function __construct()
    {
        $this->socket = new UnixSocket();
    }

    public function run()
    {
        $this->socket->create(false);
        $this->socket->connect();

        while (true) {
            $input = readline("Enter message\n");

            $this->socket->write($input);
            if ($input == 'quit' || $input == 'shutdown') {
                break;
            }
            $out = $this->socket->read();

            if ('' !== $out) {
                echo "Message from server: " . $out . "\n";
            }
        }
        $this->socket->close();

    }
}