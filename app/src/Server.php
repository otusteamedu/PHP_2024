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
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
        do {
            $connection = $this->socket->acceptConnection();
            $server_message = "\nWelcome to the chat. \n" .
                "To exit, type 'close'. To turn off the server, type 'exit'.\n";
            $this->socket->sendMessage($server_message, $connection);

            do {
                $client_message = $this->socket->readMessage($connection);
                if (!$client_message = trim($client_message)) {
                    continue;
                }
                elseif ($client_message === 'close') {
                    break;
                }
                elseif ($client_message === 'exit') {
                    break 2;
                }
                $server_message = sprintf("Client send message: '%s'\n", $client_message);
                $this->socket->sendMessage($server_message, $connection);
                echo "$client_message\n";
            } while (true);

            $this->socket->close($connection);
            break;
        } while (true);
        $this->socket->close();
        echo 'Server stopped' . PHP_EOL;
    }
}
