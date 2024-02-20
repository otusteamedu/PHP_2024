<?php

namespace GoroshnikovP\Hw6\Chat;

use GoroshnikovP\Hw6\Dtos\SocketConfigDto;
use GoroshnikovP\Hw6\Dtos\SocketReceiveDto;
use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use Socket;

abstract class Chat
{
    const SERVER_EXIT = 'server_exit';
    const CLIENT_EXIT = 'client_exit';
    const SOCKET_BUFFER_SIZE = 65536;
    protected Socket $socket;

    public function __construct(protected SocketConfigDto $socketConfig) {}

    /**
     * @throws RuntimeException
     */
    protected function socketInit(string $socketFileName): void {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($socket instanceof Socket) {
            $this->socket = $socket;
            unset($socket);
        } else {
            throw new RuntimeException('не удалось создать сокет');
        }

        if (!socket_bind($this->socket, $socketFileName)) {
            throw new RuntimeException("не удалось привязать сокет к файлу {$socketFileName}. " .
                socket_strerror(socket_last_error($this->socket)));
        }
    }


    /**
     * @throws RuntimeException
     */
    protected function socketSend(string $socketFileName, $data): void {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException("не удалось снять блокировку сокет. " .
                socket_strerror(socket_last_error($this->socket)));
        }

        $lengthData = strlen($data);
        $bytesSent = socket_sendto($this->socket, $data, $lengthData, 0, $socketFileName);
        if ($lengthData !== $bytesSent) {
            throw new RuntimeException("данные отправлены не полностью в {$socketFileName}. " .
                socket_strerror(socket_last_error($this->socket)));
        }

    }

    /**
     * @throws RuntimeException
     */
    protected function socketReceive(): SocketReceiveDto {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException("не удалось заблокировать сокет. " .
                socket_strerror(socket_last_error($this->socket)));
        }

        $returned = new SocketReceiveDto();
        $returned->ReceivedBytes = socket_recvfrom(
            $this->socket,
            $returned->data,
            static::SOCKET_BUFFER_SIZE,
            0,
            $returned->from,
        );

        if ($returned->ReceivedBytes < 0) {
            throw new RuntimeException("данные не получены. " .
                socket_strerror(socket_last_error($this->socket)));
        }

        return $returned;
    }

    public abstract function run(): void;

}
