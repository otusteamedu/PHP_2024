<?php

namespace Ahor\Hw5;

class Client extends Chat
{
    public function start(): void
    {
        echo "Старт клиента" . PHP_EOL;

        $this->create();
        $this->connect();

        $run = true;
        while ($run) {
            echo 'Введите сообщение и нажмите Enter: ' . PHP_EOL;

            $message = readline();
            $this->send($message);

            if ($message === 'stop') {
                $run = false;
            }
        }

        $this->close();
    }
}
