<?php

namespace SlavaMakhov\OtusTestApp;

use Exception;
use Generator;

class Server
{
    /** @var SocketService */
    public SocketService $socketService;

    /**
     * @param string $file
     * @param string $length
     */
    public function __construct(string $file, string $length)
    {
        $this->socketService = new SocketService($file, $length);
        echo "Ожидание сообщений от клиента. Для выхода нажмите CTRL + C" . PHP_EOL;
    }

    /**
     * Старт сервера
     *
     * @param bool $exceptionTest
     *
     * @return void
     * @throws Exception
     */
    public function run(bool $exceptionTest = false)
    {
        $this->connect();

        while (true) {
            foreach ($this->getMessage() as $msg) {
                echo "Пользователь прислал сообщение: " . $msg;
            }
            if ($exceptionTest) {
                break;
            }
        }
        $this->close();
    }

    /**
     * Метод создает сессию
     *
     * @throws Exception
     */
    public function connect()
    {
        $this->socketService->create();
        $this->socketService->bind();
        $this->socketService->listen();
        $this->socketService->accept();
    }

    /**
     * Метод закрывает сессию
     *
     * @return void
     * @throws Exception
     */
    public function close()
    {
        $this->socketService->closeSession();
    }

    /**
     * Метод получает сообщения от клиента
     *
     * @return Generator
     * @throws Exception
     */
    public function getMessage(): Generator
    {
        foreach ($this->socketService->readMessage() as $msg) {
            yield $msg;
        }
    }
}
