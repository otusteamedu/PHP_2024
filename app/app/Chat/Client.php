<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Chat;

use Exception;

final class Client extends AbstractChat
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->socket->create();
        $this->socket->connect();
        while (true) {
            $input = readline("Type your message to server \n");

            $this->socket->sendMessage($input);
            echo "Message sent\n";

            if ($input === 'stop') {
                break;
            }

            $message = $this->socket->getMessage();
            echo sprintf("MESSAGE '%s' from server \n", $message);
        }
    }
}
