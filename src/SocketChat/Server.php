<?php

namespace SocketChat;

class Server extends Socket
{
    public function run(): void
    {
        $this->create();
        $this->bind();
        $this->listen();

        $client = $this->accept();

        while (true) {
            $message = $this->read($client);

            echo "Сообщение от клиента: {$message}" . PHP_EOL;

            if ($message === 'exit') {
                break;
            }

            $this->send($client, 'Сообщение получено - ' . strlen($message) . ' символа' . PHP_EOL);
        }

        $this->close();
    }
}