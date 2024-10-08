<?php

namespace Ali\Socket;

class Server
{
    public Socket $socket;

    public function __construct($file, $length)
    {
        if (file_exists($file)) {
            unlink($file);
        }
        $this->socket = new Socket($file, $length);
        echo "Ожидание сообщений..." . PHP_EOL;
    }

    public function app()
    {
        $this->socket->bind();
        $this->socket->listen();
        $this->socket->accept();

        while (true) {
            foreach ($this->socket->readMessage() as $message) {
                echo "Получено сообщение: $message" . PHP_EOL;
                $confirmationMessage = "Received " . strlen($message) . " bytes";
                socket_write($this->socket->client, $confirmationMessage);
            }
        }
        $this->socket->closeSession();
    }
}
