<?php

namespace Ahor\Hw5;

class Client extends Chat
{
    public function start(): \Generator
    {
        yield  "Старт клиента" . PHP_EOL;

        $this->create();
        $this->connect();

        $run = true;
        while ($run) {
            $message = readline('Введите сообщение и нажмите Enter: ');
            $this->send($message);

            if ($message === 'stop') {
                $run = false;
            }
        }

        $this->close();
    }
}
