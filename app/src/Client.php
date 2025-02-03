<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusChatSocketsApp;

use Exception;
use Generator;

class Client
{
    /** @var SocketService */
    public SocketService $socketService;

    /**
     * @throws Exception
     */
    public function __construct(string $file, int $length)
    {
        $this->socketService = new SocketService($file, $length);
        echo 'Введите свое сообщение ниже. Для выхода нажмите CTRL + C' . PHP_EOL;
    }

    /**
     * Старт клиента
     *
     * @throws Exception
     */
    public function run(): void
    {
        $this->socketService->socketConnect();

        while (true) {
            foreach ($this->getMessages() as $msg) {
                if (!$this->socketService->sendMessage(
                    $this->socketService->socket,
                    PHP_EOL . "Сообщение от клиента: {$msg}" . PHP_EOL
                )) {
                    $this->socketService->closeSession();
                    return;
                }

                foreach ($this->socketService->readMessage($this->socketService->socket) as $message) {
                    echo $message;
                }
            }
        }

        $this->socketService->closeSession();
    }

    /**
     * Метод читает строки из файла сокета
     *
     * @return Generator
     */
    private function getMessages(): Generator
    {
        yield fgets(STDIN);
    }
}
