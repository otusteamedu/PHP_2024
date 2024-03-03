<?php

declare(strict_types=1);

namespace App;

use Socket;

class ClientApp implements AppInterface
{
    private Socket $socket;

    private MessageEncoderInterface $messageEncoder;

    /**
     * @throws DomainException
     */
    public function __construct(string $server_address, MessageEncoderInterface $messageEncoder)
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new DomainException('Не удалось создать сокет - ' . socket_strerror(socket_last_error()));
        }

        if (!socket_connect($socket, $server_address)) {
            throw new DomainException(
                'Не удалось подключиться к серверу - ' . socket_strerror(socket_last_error())
            );
        }

        $this->socket = $socket;
        $this->messageEncoder = $messageEncoder;
    }

    /**
     * @throws DomainException
     */
    public function run(): void
    {
        $isRunning = true;
        while ($isRunning) {
            $sockets = [$this->socket];
            $write = NULL;
            $except = NULL;

            if (socket_select($sockets, $write, $except, 0)) {
                if ($out = socket_read($this->socket, 1024)) {
                    $msg = $this->messageEncoder->decode($out);
                    echo "$msg\n";
                } else {
                    throw new DomainException('Пропало соединение с сервером');
                }
            }

            if ($input = ConsoleHelper::getNotBlockingInputFromSTDIN()) {
                $msg = $this->messageEncoder->encode($input);
                socket_write($this->socket, $msg, strlen($msg));
            }
        }
    }
}
