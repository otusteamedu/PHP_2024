<?php

declare(strict_types=1);

namespace App;

use Generator;

class Server
{
    private string $buf = '';
    private string $from = '';
    public string $server_side_sock;
    public string $stop_word;


    /**
     * @return Generator
     * @throws SocketErrorException
     */
    public function createServer(): Generator
    {
        if (!extension_loaded('sockets')) {
            return $this->getSocketError('The sockets extension is not loaded.');
        }
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            return $this->getSocketError('Unable to create AF_UNIX socket');
        }

        $this->server_side_sock = __DIR__ . Base::getConfig('server_side_sock');

        if (!socket_bind($socket, $this->server_side_sock)) {
            return $this->getSocketError("Unable to bind to $this->server_side_sock");
        }

        $isRunning = true;
        while ($isRunning) {
            if (!socket_set_block($socket)) {
                return $this->getSocketError('Unable to set blocking mode for socket');
            }
            yield "Ready to receive...\n";
            $this->buf = $this->waitQueryFromClient($socket);
            yield "Received '$this->buf' from '$this->from' and count bytes are " . strlen($this->buf) . "\n";
            yield "Request processed\n";
            if ($this->buf != '') {
                $this->sendResponse($socket, $isRunning);
            }
            if (!$isRunning) {
                yield "Server exits\n";
            }
        }
        yield $isRunning;
    }


    /**
     * @param $socket
     * @return object|string
     * @throws SocketErrorException
     */
    public function waitQueryFromClient($socket): object|string
    {
        $bytes_received = socket_recvfrom($socket, $this->buf, 65536, 0, $this->from);
        if ($bytes_received == -1) {
            return $this->getSocketError('An error occurred while receiving from the socket');
        }
        return  $this->buf;
    }


    /**
     * @param $socket
     * @param $isRunning
     * @return object|bool
     * @throws SocketErrorException
     */
    public function sendResponse($socket, &$isRunning): object|bool
    {
        $this->stop_word = Base::getConfig('stop_word');
        if (strtolower(trim($this->buf)) == $this->stop_word) {
            $isRunning = false;
            socket_sendto($socket, $this->buf, strlen($this->buf), 0, $this->from);
            socket_close($socket);
            unlink($this->server_side_sock);
            return $isRunning;
        }
        if (!socket_set_nonblock($socket)) {
            return $this->getSocketError('Unable to set nonblocking mode for socket');
        }
        $len = strlen($this->buf);
        $bytes_sent = socket_sendto($socket, $this->buf, $len, 0, $this->from);
        if ($bytes_sent == -1) {
            return $this->getSocketError('An error occurred while sending to the socket');
        } elseif ($bytes_sent != $len) {
            return $this->getSocketError($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
        }
        return $isRunning;
    }

    /**
     * @param string $message
     * @return object
     * @throws SocketErrorException
     */
    public function getSocketError(string $message): object
    {
        throw new SocketErrorException($message);
    }
}
