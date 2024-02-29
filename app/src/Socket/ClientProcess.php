<?php

declare(strict_types=1);

namespace App\src\Socket;

use App\src\Contracts\ProcessInterface;
use App\src\Enums\CommandEnum;
use Exception;

class ClientProcess extends AbstractProcess implements ProcessInterface
{
    /**
     * @throws Exception
     */
    public function init(): void
    {
        $this->close();
        $this->create();
        $this->connect();
    }

    /**
     * @throws Exception
     */
    public function run(): \Fiber
    {

        return new \Fiber(function () {
            $this->init();

            do {
                if (!$this->socket) {
                    continue;
                }

                $message = readline('Введите сообщение: ');

                $this->runProcess = CommandEnum::tryFrom(trim($message)) !== CommandEnum::STOP;

                $send = $this->write($message, $this->socket);

                if (!$send) {
                    \Fiber::suspend("Сообщение не отправлено!");
                    $this->init();
                    continue;
                }

                $message = $this->read($this->socket);

                if (!empty(trim($message))) {
                    \Fiber::suspend($message);
                }

            } while ($this->runProcess);
        });
    }

    /**
     * @throws Exception
     */
    private function connect(): void
    {
        socket_connect($this->socket, $this->socketPath);
    }
}
