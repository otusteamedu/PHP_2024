<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Socket;

use Exception;

class Service
{
    private const SOCKET_ADDRESS_ALREADY_IN_USE_ERROR_CODE = 98;

    /**
     * @return resource
     * @throws Exception
     */
    public function create()
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }

        // create unix udp socket
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$socket) {
            throw new Exception('Unable to create AF_UNIX socket');
        }

        return $socket;
    }

    /**
     * @param $socket
     * @param string $sockFilePath
     * @return void
     * @throws Exception
     */
    public function bind($socket, string $sockFilePath): void
    {
        try {
            socket_bind($socket, $sockFilePath);
        } catch (\Throwable $exception) {
            $socketErrorCode = socket_last_error();
            if ($socketErrorCode === self::SOCKET_ADDRESS_ALREADY_IN_USE_ERROR_CODE) {
                unlink($sockFilePath);
                socket_bind($socket, $sockFilePath);
            }

            throw new Exception(
                'Unable to bind to: ' . $sockFilePath . PHP_EOL
                . 'Error: ' . socket_strerror($socketErrorCode) . PHP_EOL
                . 'Exception: ' . $exception->getMessage()
            );
        }
    }

    /**
     * @param $socket
     * @return array
     * @throws Exception
     */
    public function receive($socket): array
    {
        if (!socket_set_block($socket)) {
            throw new Exception('Unable to set blocking mode for socket');
        }

        $buf = '';
        $from = '';

        $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);

        if ($bytes_received == -1) {
            throw new Exception('An error occured while receiving from the socket');
        }

        echo "Received $buf from $from \n";

        return [$buf, $from];
    }

    /**
     * @param $socket
     * @param string $buf
     * @param string $from
     * @return void
     * @throws Exception
     */
    public function send($socket, string $buf, string $from): void
    {
        // send response
        if (!socket_set_nonblock($socket)) {
            throw new Exception('Unable to set nonblocking mode for socket');
        }

        // client side socket filename is known from client request: $from
        $len = strlen($buf);
        $bytes_sent = socket_sendto($socket, $buf, $len, 0, $from);

        if ($bytes_sent == -1) {
            throw new Exception('An error occured while sending to the socket');
        } elseif ($bytes_sent != $len) {
            throw new Exception($bytes_sent
              . ' bytes have been sent instead of the '
              . $len
              . ' bytes expected');
        }
    }
}
