<?php

namespace SlavaMakhov\OtusTestApp;

use Exception;
use Generator;

class Client
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
    }

    /**
     * Старт клиента
     *
     * @param bool $exceptionTest
     *
     * @return void
     * @throws Exception
     */
    public function run(bool $exceptionTest = false): void
    {
        $this->connect();

        while (true) {
            foreach ($this->getMessage() as $msg) {
                if (!$this->sendMessage(PHP_EOL . "Сообщение от клиента: {$msg}" . PHP_EOL)) {
                    echo 'Не удалось отправить сообщение. Сеанс завершен' . PHP_EOL;
                    $this->close();
                    return;
                } else {
                    echo 'Отправленно сообщение: ' . $msg . PHP_EOL;
                }
            }
            if ($exceptionTest) {
                break;
            }
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function connect()
    {
        $this->socketService->create();
        $this->socketService->socketConnect();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function close()
    {
        $this->socketService->closeSession();
    }

    /**
     * @param string $msg
     *
     * @return bool
     * @throws Exception
     */
    public function sendMessage(string $msg): bool
    {
        return $this->socketService->sendMessage($msg);
    }

    /**
     * @return Generator
     */
    public function getMessage(): Generator
    {
        yield fgets(STDIN);
    }
}
