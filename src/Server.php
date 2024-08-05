<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw5;

class Server extends Socket
{
    public function process()
    {
        try {
            while (true) {
                $receivedMessage = self::receive($this->socket);
                yield "Client sent message: " . $receivedMessage['buffer'] . PHP_EOL;

                $response = "Received " . strlen($receivedMessage['buffer']) . " bytes";

                self::send($this->socket, $response, $receivedMessage['from']);
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
