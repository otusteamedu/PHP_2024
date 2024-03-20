<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

class Server
{
    private Config $config;
    private Socket $socket;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __destruct()
    {
        if ($this->socket) {
            $this->socket->removeFile();
        }
    }

    public function run()
    {
        echo 'Server started' . PHP_EOL;
        $this->socket = new Socket($this->config);
        $this->socket->removeFile();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
        do {
            $connection = $this->socket->acceptConnection();
            $server_message = "\nWelcome to the chat. \n" .
                "To exit, type 'close'. To turn off the server, type 'exit'.\n";
            $this->socket->sendMessage($server_message, $connection);

            do {
                sleep(1);
                $client_message = $this->socket->readMessage($connection);
                if (!trim($client_message)) {
                    continue;
                } elseif ($client_message === 'close') {
                    echo 'Client close connection' . PHP_EOL;
                    break;
                } elseif ($client_message === 'exit') {
                    $this->socket->close($connection);
                    echo 'Client exit server' . PHP_EOL;
                    break 2;
                }
                echo "[Client message]: $client_message\n";
                $server_message = sprintf("Server read message: %s", $client_message);
                $this->socket->sendMessage($server_message, $connection);
            } while (true);

            $this->socket->close($connection);
        } while (true);
        $this->socket->close();
        echo 'Server stopped' . PHP_EOL;
    }
}
