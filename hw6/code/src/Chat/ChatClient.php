<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\Chat;

use GoroshnikovP\Hw6\Exceptions\RuntimeException;

class ChatClient extends Chat
{
    /**
     * @throws RuntimeException
     */
    public function run(): void
    {
        $this->socketInit();

        if (!file_exists($this->socketFile)) {
            throw new RuntimeException("Похоже, сервер не запущен. " .
                socket_strerror(socket_last_error($this->socket)));
        }

        if (!socket_connect($this->socket, $this->socketFile)) {
            throw new RuntimeException("Не удалось подключиться к сокету. " .
                socket_strerror(socket_last_error($this->socket)));
        }
        while (true) {
            try {
                $msg = readline('Какое сообщение отправить? ');
                $this->socketSend($this->socket, $msg);

                if (parent::CHAT_EXIT === $msg) {
                    socket_close($this->socket);
                    echo "Отключаемся.\n";
                    break;
                }

                $answerSata = $this->socketReceive($this->socket);
                echo "Ответ: {$answerSata}\n";
            } catch (RuntimeException $ex) {
                echo $ex->getMessage() . "\n";
            }
        }
    }
}
