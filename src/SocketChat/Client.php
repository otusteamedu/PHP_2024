<?php

namespace SocketChat;

class Client extends Socket
{
    public function run(): void
    {
        $this->create();
        $this->connect();

        while (true) {
            $message = readline('Введите ваше сообщение: ');

            $this->send($this->getSocket(), $message);

            if ($message === 'exit') {
                break;
            }

            echo $this->read($this->getSocket());
        }
    }
}