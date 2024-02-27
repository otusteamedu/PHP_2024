<?php

declare(strict_types=1);

namespace Pozys\ChatConsole;

use Pozys\ChatConsole\Interfaces\Runnable;

class Client implements Runnable
{
    public function __construct(private SocketManager $socket, private Config $config)
    {
    }

    public function run(): void
    {
        $socketManager = $this->runSocket();

        $stopWord = $this->config->stopWord;

        while (true) {
            $message = readline("Write something: ");

            if ($message === false) {
                continue;
            }

            if (trim($message) === $stopWord) {
                $socketManager->close();
                break;
            }

            $socketManager->write($message);

            $answer = $socketManager->read();

            if ($answer === '') {
                continue;
            }

            echo $answer . PHP_EOL;
        }
    }

    private function runSocket(): SocketManager
    {
        return $this->socket->create()->connect();
    }
}
