<?php

declare(strict_types=1);

namespace App;

use Generator;

class Client
{
    private string $buf = '';
    private string $from = '';
    public string $server_side_sock;
    public string $client_side_sock;

    /**
     * @return Generator
     * @throws SocketErrorException
     */
    public function createClient(): Generator
    {
        if (!extension_loaded('sockets')) {
            return $this->getSocketError('The sockets extension is not loaded.');
        }
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            return $this->getSocketError('Unable to create AF_UNIX socket');
        }
        $this->client_side_sock = __DIR__ . Base::getConfig('client_side_sock');

        if (!socket_bind($socket, $this->client_side_sock)) {
            return $this->getSocketError("Unable to bind to $this->client_side_sock");
        }
        yield "Attention!!! To stop the server, enter '" . Base::getConfig('stop_word') . "'" . "\n";
        if ($this->sendData($socket)) {
            yield $this->receiveData($socket)->current();
        }
    }


    /**
     * @param $socket
     * @return bool|object
     * @throws SocketErrorException
     */
    public function sendData($socket): bool|object
    {
        if (!socket_set_nonblock($socket)) {
            return $this->getSocketError('Unable to set nonblocking mode for socket');
        }
        $this->server_side_sock = __DIR__ . Base::getConfig('server_side_sock');

        $msg = readline("Enter a message to send to the server: ");
        if (empty($msg)) {
            socket_close($socket);
            unlink($this->client_side_sock);
            return $this->getSocketError('Attention!!! You mast not send an empty message');
        }
        $len = strlen($msg);
        $bytes_sent = socket_sendto($socket, $msg, $len, 0, $this->server_side_sock);
        if ($bytes_sent == -1) {
            return $this->getSocketError('An error occurred while sending to the socket');
        } elseif ($bytes_sent != $len) {
            return $this->getSocketError($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
        }
        return true;
    }


    /**
     * @param $socket
     * @return Generator
     * @throws SocketErrorException
     */
    public function receiveData($socket): Generator
    {
        if (!socket_set_block($socket)) {
            return $this->getSocketError('Unable to set blocking mode for socket');
        }
        $bytes_received = socket_recvfrom($socket, $this->buf, 65536, 0, $this->from);
        if ($bytes_received == -1) {
            return $this->getSocketError('An error occurred while receiving from the socket');
        }
        socket_close($socket);
        unlink($this->client_side_sock);
        yield "Received '$this->buf' from '$this->from' and count of bytes are " . strlen($this->buf) . "\n" .
        "Client exits\n";
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
