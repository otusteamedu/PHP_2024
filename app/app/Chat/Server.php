<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Chat;

final readonly class Server extends AbstractChat
{
    public function run(): void
    {
        while (true) {
            $message = $this->socket->getMessage();
            echo sprintf("Received %s from %s \n", $message->getMessage(), $message->getFrom());

            $response = "Server processed your request";
            $responseMessage = new Message($this->socket->getPath(), $message->getFrom(), $response, strlen($response));

            $this->socket->sendMessage($responseMessage);
            echo "Request processed\n";
        }
    }
}
