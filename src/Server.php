<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Interface\IRun;

class Server implements IRun
{
    public function __construct(
        private readonly SocketManager $manager,
    ) {
    }

    public function run(): void
    {
        echo "\nРаботает сервер!";

        $this->manager->recreateBindAndListen();
        set_time_limit(0);

        while (true) {
            $socket = $this->manager->accept();

            while (true) {
                $msg = trim($this->manager->read($socket));

                if ($msg === '') {
                    break;
                }

                echo "Получено сообщение: $msg" . PHP_EOL;
                $size = strlen($msg);
                $this->manager->write("Получено {$size} байт", $socket);
            }
        }

    }
}
