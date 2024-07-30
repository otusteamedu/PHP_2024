<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw5;

class Socket
{
    public static function create(?string $name = 'default'): \Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            throw new \Exception('Could not create socket');
        }

        $socketFilePath = dirname(__FILE__) . "/" . $name . ".sock";
        if (!socket_bind($socket, $socketFilePath)) {
            throw new \Exception('Could not bind socket');
        }

        return $socket;
    }

    public static function send(\Socket $socket, string $message, string $destination)
    {
        $bytesSent = socket_sendto($socket, $message, strlen($message), 0, $destination);

        if ($bytesSent == -1) {
            throw new \Exception('Could not send message');
        } else if ($bytesSent != strlen($message)) {
            throw new \Exception('An error occurred during sending message');
        }

        return $bytesSent;
    }

    public static function receive(\Socket $socket): array
    {
        $buffer = '';
        $from = '';

        $bytesReceived = socket_recvfrom($socket, $buffer, SOCKET_RECEIVE_MAX_SIZE_B, 0, $from);

        if ($bytesReceived == -1) {
            throw new \Exception('Could not receive from socket');
        }

        return [
            'buffer' => $buffer,
            'from' => $from,
        ];
    }
}
