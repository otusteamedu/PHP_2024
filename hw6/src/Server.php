<?php

class Server
{
    private $socketPath;

    public function __construct($socketPath)
    {
        $this->socketPath = $socketPath;
    }

    public function run()
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new Exception("Could not create socket.");
        }

        if (!socket_bind($socket, $this->socketPath)) {
            throw new Exception("Could not bind to socket.");
        }

        socket_listen($socket);

        echo "Server listening on {$this->socketPath}\n";

        while (true) {
            $clientSocket = socket_accept($socket);
            $data = socket_read($clientSocket, 1024);
            echo "Received message: $data\n";
            $response = "Received " . strlen($data) . " bytes\n";
            socket_write($clientSocket, $response);
        }
    }
}
