<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw5;

class Client extends Socket
{
    public static function init()
    {
        echo "Client started. You can send your messages below" . PHP_EOL;

        try {
            $socket = self::create(CLIENT_SOCKET_FILE_NAME);

            if (!socket_set_nonblock($socket)) {
                throw new \Exception('Could not set nonblocking mode for socket');
            }

            $serverSocket = dirname(__FILE__)."/server.sock";

            $handle = fopen("php://stdin", "r");

            while (true) {
                $message = fgets($handle);

                $bytesSent = self::send($socket, $message, $serverSocket);

                if (!socket_set_block($socket)) {
                    throw new \Exception('Could not set blocking mode for socket');
                }

                $receivedMessage = self::receive($socket);

                echo 'Server Response: ' . $receivedMessage['buffer'] . PHP_EOL;
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

    }
}