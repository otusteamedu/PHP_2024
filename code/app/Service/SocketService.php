<?php

declare(strict_types=1);

namespace IGalimov\Hw5\Service;

class SocketService
{
    public $socket;
    protected $socketPath;
    protected $socketStatus;

    /**
     * @throws \Exception
     */
    protected function checkAvailableAndPrepareToCreate(): void
    {
        if (!extension_loaded('sockets')) {
            throw new \Exception("The sockets extension is not loaded.");
        }

        if ($this->checkSocketExists($this->socketPath)){
            unlink($this->socketPath);
        }

    }

    /**
     * @param string $pathToSocket
     * @throws \Exception
     */
    public function createSocket(string $pathToSocket): void
    {
        $this->socketPath = $pathToSocket;

        $this->checkAvailableAndPrepareToCreate();

        $this->socketInit();
    }


    /**
     * @param string $pathToSocket
     * @return bool
     */
    public function checkSocketExists(string $pathToSocket): bool
    {
        return file_exists($pathToSocket);
    }

    /**
     * @throws \Exception
     */
    protected function socketInit(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new \Exception("Unable to create AF_UNIX socket.");
        }

        if (!socket_bind($this->socket, $this->socketPath)) {
            throw new \Exception("Unable to bind to $this->socketPath.");
        }

        $this->socketStatus = true;

        echo "Chat is ready (type '!exit' to stop):\n";
    }

    /**
     * @throws \Exception
     */
    protected function blockSocket(): void
    {
        if (!socket_set_block($this->socket)) {
            throw new \Exception("Unable to set blocking mode for socket.");
        }
    }

    /**
     * @throws \Exception
     */
    protected function unblockSocket(): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new \Exception("Unable to set nonblocking mode for socket.");
        }
    }

    /**
     * @param string $buf
     * @param string $from
     * @return array
     * @throws \Exception
     */
    protected function receiveMessages(string $buf = '', string $from = ''): array
    {
        $bytesReceived = socket_recvfrom($this->socket, $buf, 65536, 0, $from);

        if ($bytesReceived == -1) {
            throw new \Exception("An error occured while receiving from the socket.");
        }

        echo "$from:\n $buf \n";

        return compact('buf', 'from');
    }

    /**
     * @param string $message
     * @param string $from
     * @throws \Exception
     */
    protected function sendMessage(string $message, string $from): void
    {
        $len = strlen($message);

        $bytesSent = socket_sendto($this->socket, $message, $len, 0, $from);

        if ($bytesSent == -1) {
            throw new \Exception("An error occured while sending to the socket.");
        } else if ($bytesSent != $len) {
            throw new \Exception("$bytesSent bytes have been sent instead of the $len bytes expected.");
        }
    }

    /**
     * @throws \Exception
     */
    protected function closeSocket(): void
    {
        $this->socketStatus = false;

        socket_close($this->socket);

        unlink($this->socketPath);

        throw new \Exception("Chat ended...");
    }

}
