<?php

class Client
{
    private $socketPath;

    public function __construct($socketPath)
    {
        $this->socketPath = $socketPath;
    }

    public function run()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new Exception("Could not create socket.");
        }

        if (!socket_connect($socket, $this->socketPath)) {
            throw new Exception("Could not connect to server.");
        }

        while (true) {
            echo "Enter message: ";
            $message = trim(fgets(STDIN));
            socket_write($socket, $message);

            $response = socket_read($socket, 1024);
            echo "Server response: $response\n";
        }
    }
}
