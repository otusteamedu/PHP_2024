<?php

namespace SocketChat;

class Client extends Socket
{
    public function run(): void
    {
        $this->create();
        $this->connect();

        while (true) {
            $message = $this->getUserInput('Введите ваше сообщение: ');

            $this->send($this->getSocket(), $message);

            if ($message === 'exit') {
                break;
            }

            echo $this->read($this->getSocket());
        }
    }

    protected function getUserInput(string $prompt): string
    {
        return readline($prompt);
    }
}