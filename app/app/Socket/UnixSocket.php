<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Socket;

use Exception;
use Rmulyukov\Hw5\Chat\Message;
use Socket;

final readonly class UnixSocket
{
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct(private string $path)
    {
        if (file_exists($this->path)) {
            $this->removeFile();
        }
        if (!($socket = socket_create(AF_UNIX, SOCK_DGRAM, 0))) {
            throw new Exception('Unable to create AF_UNIX socket');
        }
        $this->socket = $socket;

        if (!socket_bind($this->socket, $this->path)) {
            throw new Exception("Unable to bind to $this->path");
        }
    }

    /**
     * @throws Exception
     */
    public function getMessage(): Message
    {
        if (!socket_set_block($this->socket)) {
            throw new Exception('Unable to set blocking mode for socket');
        }

        $message = '';
        $from = '';
        echo "Ready to receive...\n";

        // block to wait client query
        $receivedBytes = socket_recvfrom($this->socket, $message, 65536, 0, $from);
        if (!$receivedBytes || $receivedBytes == -1) {
            throw new Exception('An error occurred while receiving from the socket');
        }

        return new Message($from, $this->path, $message, $receivedBytes);
    }

    /**
     * @throws Exception
     */
    public function sendMessage(Message $message): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new Exception('Unable to set nonblocking mode for socket');
        }

        // client side socket filename is known from client request: $from
        $sentBytes = socket_sendto(
            $this->socket,
            $message->getMessage(),
            $message->getLength(),
            0,
            $message->getTo()
        );

        if ($sentBytes == -1) {
            throw new Exception('An error occurred while sending to the socket');
        }
        if ($sentBytes !== $message->getLength()) {
            throw new Exception(
                sprintf('expected %d bytes, but have been sent %d', $message->getLength(), $sentBytes)
            );
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @throws Exception
     */
    public function removeFile(): void
    {
        if (file_exists($this->path) && !unlink($this->path)) {
            throw new Exception("Could not to remove socket file {$this->path}");
        }
    }
}
