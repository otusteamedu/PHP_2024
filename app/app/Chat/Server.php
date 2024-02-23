<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Chat;

use Exception;

final class Server extends AbstractChat
{
    public function __construct(string $socketPath)
    {
        parent::__construct($socketPath);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->socket->removeFile();
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
        while (true) {
            echo "Expecting connections\n";
            $connection = $this->socket->getConnection();

            while (true) {
                $message = $this->socket->getMessage($connection);
                if ($message === 'stop') {
                    break;
                }

                echo sprintf("Received %s from %s \n", $message, 'client');

                $this->socket->sendMessage("Server processed your request", $connection);
                echo "Request processed\n";
            }

            $this->socket->closeConnection($connection);
            echo "Connection closed\n\n";
        }
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->socket->removeFile();
    }
}
