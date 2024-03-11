<?php

declare(strict_types=1);

namespace IlyaPlotnikov\SocketChat;

class ChatService
{
    private string $mode;

    public function __construct(string $mode)
    {
        $this->mode = $mode;
    }

    public function run()
    {
        // Create a new socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        // Bind the socket to an address and port
        $address = '127.0.0.1';
        $port = 8080;
        socket_bind($socket, $address, $port);

        // Listen for incoming connections
        socket_listen($socket);

        // Accept incoming connections
        $client_sockets = [];

        echo 123;
        while (true) {
            $new_socket = socket_accept($socket);
            $client_sockets[] = $new_socket;

            // Read messages from clients
            foreach ($client_sockets as $key => $client_socket) {
                $message = socket_read($client_socket, 1024);

                // Broadcast messages to all connected clients
                if (!empty($message)) {
                    foreach ($client_sockets as $client) {
                        socket_write($client, $message);
                    }
                } else {
                    // Remove disconnected clients
                    unset($client_sockets[$key]);
                    socket_close($client_socket);
                }
            }
        }
    }
}
