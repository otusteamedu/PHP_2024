<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw5;

class Client extends Socket
{

    public function process()
    {
        try {
            $serverSocket = dirname(__FILE__) . "/server.sock";

            $handle = fopen("php://stdin", "r");

            while (true) {
                $message = fgets($handle);

                $bytesSent = self::send($this->socket, $message, $serverSocket);

                $receivedMessage = self::receive($this->socket);

                yield 'Server Response: ' . $receivedMessage['buffer'] . PHP_EOL;
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
