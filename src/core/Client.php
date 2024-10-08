<?php

namespace Ali\Socket;

class Client
{
    public Socket $socket;

    public function __construct($file, $length)
    {
        $this->socket = new Socket($file, $length);
    }

    public function app(): void
    {
        $this->socket->socketConnect();
        while (true) {
            foreach ($this->getMessage() as $message) {
                if (!$this->socket->sendMessage($message)) {
                    echo 'Не удалось отправить сообщение. Сеанс завершен' . PHP_EOL;
                    $this->socket->closeSession();
                    return;
                }
                $confirmation = $this->socket->readConfirmation();
                echo "Подтверждение от сервера: $confirmation" . PHP_EOL;
            }
        }
    }

    private function getMessage(): \Generator
    {
        echo 'Введите сообщение...' . PHP_EOL;
        yield fgets(STDIN);
    }
}
