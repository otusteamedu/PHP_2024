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
    }

    /**
     * Старт клиента
     *
     * @throws Exception
     */
    public function run(): void
    {
        $this->socketService->socketConnect();
        echo 'Введите свое сообщение ниже. Для выхода нажмите CTRL + C' . PHP_EOL;

        while (true) {
            foreach ($this->getMessages() as $msg) {
                if (!$this->socketService->sendMessage($this->socketService->socket, $msg)) {
                    echo 'Ошибка отправки сообщения! Сеанс завершен.' . PHP_EOL;
                    $this->socketService->closeSession();
                    return;
                }

                echo $this->socketService->readMessage($this->socketService->socket);
            }
        }
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
