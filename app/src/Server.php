<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusChatSocketsApp;

use Exception;

class Server
{
    /** @var string */
    protected string $file;

    /** @var SocketService */
    public SocketService $socketService;

    /**
     * @throws Exception
     */
    public function __construct(string $file, int $length)
    {
        $this->file = $file;
        $this->socketService = new SocketService($file, $length);
        echo "Ожидание сообщений от клиента. Для выхода нажмите CTRL + C" . PHP_EOL;
    }

    /**
     * Старт сервера
     *
     * @throws Exception
     */
    public function run(): void
    {
        $this->socketService->clearFile($this->file);
        $this->socketService->bind();
        $this->socketService->listen();
        $this->socketService->accept();

        while (true) {
            foreach ($this->socketService->readMessage($this->socketService->client) as $message) {
                if ($message === 'exit') {
                    break;
                } else {
                    echo $message;
                }

                if (!$this->socketService->sendMessage(
                    $this->socketService->client,
                    PHP_EOL . 'Ответ от сервера: получено ' . strlen($message) . ' байт' . PHP_EOL
                )) {
                    $this->socketService->closeSession();
                    return;
                }
            }
        }

        $this->socketService->closeSession();
    }
}
