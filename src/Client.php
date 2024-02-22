<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

class Client
{
    public function run(): void
    {
        $socket = new SocketManager();
        $socket->runClient();
        $stopWord = App::getConfig('socket.stop_word');

        while (true) {
            $message = readline("Write something: ");

            if ($message === false) {
                continue;
            }

            $socket->write($message);

            if (trim($message) === $stopWord) {
                break;
            }

            $answer = $socket->read();

            if ($answer === '') {
                continue;
            }

            echo $answer . PHP_EOL;
        }
    }
}
