<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\Chat;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;

class ChatServer extends Chat
{
    /**
     * @throws RuntimeException
     */
    public function run(): void
    {
        $this->socketInit($this->socketConfig->fileNameServer);
        while (true) {
            $receivedInfo = $this->socketReceive();
            if (parent::SERVER_EXIT === $receivedInfo->data) {
                $messageToAnswer = "Сервер остановлен.";
                $this->socketSend($receivedInfo->from, $messageToAnswer);
                $this->serverBreak();
                break;
            }

            echo "Получено сообщение {$receivedInfo->data}\n";
            $countChars = mb_strlen($receivedInfo->data);
            $messageToAnswer = "Получено {$receivedInfo->ReceivedBytes} bytes, {$countChars} symbol";
            $this->socketSend($receivedInfo->from, $messageToAnswer);
        }
    }

    private function serverBreak()
    {
        socket_close($this->socket);
        $fileName = $this->socketConfig->fileNameServer;
        if (file_exists($fileName)) {
            unlink($fileName);
        }
        echo 'Server exits';
    }
}
