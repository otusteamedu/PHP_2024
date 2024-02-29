<?php

declare(strict_types=1);

namespace App\src\Socket;

use App\src\Contracts\ProcessInterface;
use App\src\Enums\CommandEnum;
use Exception;

class ServerProcess extends AbstractProcess implements ProcessInterface
{
    /**
     * @throws Exception
     */
    public function init(): void
    {
        $this->kill();
        $this->create();
        $this->bind();
        $this->listen();
    }

    /**
     * @throws Exception
     */
    public function run(): \Fiber
    {
        return new \Fiber(function () {
            $socket = $this->accept();

            do {
                $message = $this->read($socket);

                if (!empty(trim($message))) {
                    \Fiber::suspend("Сообщение от клиента: {$message}");
                    $length = mb_strlen($message);
                    $this->write("Принято {$length}b" . PHP_EOL, $socket);
                }

                $this->runProcess = CommandEnum::tryFrom(trim($message)) !== CommandEnum::STOP;
            } while ($this->runProcess);

            $this->kill();
        });
    }

    /**
     * @throws Exception
     */
    private function listen(): void
    {
        socket_listen($this->socket) or throw new Exception('Ошибка при чтении к сокета.');
    }

    private function kill(): void
    {
        if ($this->socket) {
            $this->close();
        }

        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }
    }
}
