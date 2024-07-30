<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw5;

class Server extends Socket
{
    public static function init()
    {
        echo "Server started. Listening for client messages..." . PHP_EOL;

        try {
            $socket = self::create(SERVER_SOCKET_FILE_NAME);

            while (true) {
                if (!socket_set_block($socket)) {
                    throw new \Exception('Could not set blocking mode for socket');
                }

                $receivedMessage = self::receive($socket);
                echo "Client sent message: " . $receivedMessage['buffer'] . PHP_EOL;

                $response = "Received " . strlen($receivedMessage['buffer']) . " bytes";

                if (!socket_set_nonblock($socket)) {
                    throw new \Exception('Could not set nonblocking mode for socket');
                }

                self::send($socket, $response, $receivedMessage['from']);
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
