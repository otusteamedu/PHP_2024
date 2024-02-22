<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\Chat;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;
use Socket;

class ChatServer extends Chat
{
    /**
     * @throws RuntimeException
     */
    public function run(): void
    {
        $this->socketInit();

        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }
        if (!socket_bind($this->socket, $this->socketFile)) {
            throw new RuntimeException("Не удалось привязать сокет к файлу {$this->socketFile}. " .
                socket_strerror(socket_last_error($this->socket)));
        }

        if (!socket_listen($this->socket, 1)) {
            throw new RuntimeException("Не удалось сокет {$this->socketFile} перевести в режим прослушивания. " .
                socket_strerror(socket_last_error($this->socket)));
        }

        while (true) {
            if (!($connectedSocket = socket_accept($this->socket))) {
                throw new RuntimeException("Ошибка socket_accept. " .
                    socket_strerror(socket_last_error($this->socket)));
            }

            $this->processingClient($connectedSocket);
        }

        //  Если в дальнейших доработках предусмотрится выход из цикла выше, то сработает эта часть кода.
//         socket_close($this->socket);
    }


    /**
     * Подразумевается, что при отключении клиента, сервер продолжает ждать следующего клиента.
     * В этом методе, обработка одного подключения клиента.
     */
    private function processingClient(Socket $connectedSocket): void
    {
        try {
            while (true) {
                $receivedData = $this->socketReceive($connectedSocket);
                if (parent::CHAT_EXIT === $receivedData) {
                    socket_close($connectedSocket);
                    echo "Клиент отключился.\n";
                    break;
                }

                echo "Получено сообщение: {$receivedData}\n";
                $countChars = mb_strlen($receivedData);
                $countBytes = strlen($receivedData);
                $messageToAnswer = "Получено {$countBytes} bytes, {$countChars} symbol";
                $this->socketSend($connectedSocket, $messageToAnswer);
            }
        } catch (RuntimeException $ex) {
            echo "Ошибка при обработке клинта. {$ex->getMessage()} . Ожидаем другого клиента.\n";
        }
    }
}
