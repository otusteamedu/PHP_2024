<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use GoroshnikovP\Hw6\SocketManager\ClientSocketManager;
use GoroshnikovP\Hw6\SocketManager\ServerSocketManager;

class Chat
{
    const CHAT_EXIT = 'chat_exit';

    public function __construct(protected string $socketFile)
    {
    }

    /**
     * @throws RuntimeException
     */
    public function runClient(): void
    {
        $clientSocketManager = new ClientSocketManager($this->socketFile);
        $clientSocketManager->socketInit();
        while (true) {
            try {
                $msg = readline('Какое сообщение отправить? ');
                $clientSocketManager->socketSend($msg);
                if (static::CHAT_EXIT === $msg) {
                    $clientSocketManager->socketClose();
                    echo "Отключаемся.\n";
                    break;
                }

                $answerSata = $clientSocketManager->socketReceive();
                echo "Ответ: {$answerSata}\n";
            } catch (RuntimeException $ex) {
                echo $ex->getMessage() . "\n";
            }
        }
    }

    /**
     * @throws RuntimeException
     */
    public function runServer(): void
    {
        $serverSocketManager = new ServerSocketManager($this->socketFile);
        $serverSocketManager->socketInit();
        while (true) {
            $serverSocketManager->awaitClient();
            try {
                while (true) {
                    $receivedData = $serverSocketManager->socketReceive();
                    if (static::CHAT_EXIT === $receivedData) {
                        $serverSocketManager->socketClose();
                        echo "Клиент отключился.\n";
                        break;
                    }

                    echo "Получено сообщение: {$receivedData}\n";
                    $countChars = mb_strlen($receivedData);
                    $countBytes = strlen($receivedData);
                    $messageToAnswer = "Получено {$countBytes} bytes, {$countChars} symbol";
                    $serverSocketManager->socketSend($messageToAnswer);
                }
            } catch (RuntimeException $ex) {
                echo "Ошибка при обработке клинта. {$ex->getMessage()} . Ожидаем другого клиента.\n";
            }
        }
    }
}
