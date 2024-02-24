<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use Pozys\ChatConsole\Interfaces\Runnable;

class Client implements Runnable
{
    public function __construct(private SocketManager $socket, private string $stopWord)
    {
    }

    public function run(): void
    {
        $socket = $this->socket->create()->connect();

        while (true) {
            $message = readline("Write something: ");

            if ($message === false) {
                continue;
            }

            if (trim($message) === $this->stopWord) {
                $socket->close();
                break;
            }

            $socket->write($message);

            $answer = $socket->read();

            if ($answer === '') {
                continue;
            }

            echo $answer . PHP_EOL;
        }
    }
}
