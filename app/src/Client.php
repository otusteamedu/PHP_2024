<?php

declare(strict_types=1);

namespace Dw\OtusSocketChat;

use Dw\OtusSocketChat\Application\BaseApplication;
use Exception;

class Client extends BaseApplication
{
    /**
     * @throws Exception
     */
    public function run()
    {
        if (!socket_connect($this->socket, $this->socketPath)) {
            throw new Exception("Ошибка подключения, запустите сервер");
        }

        while (true) {
            $inputDataLine = readline("Введите сообщение: ");

            if ($inputDataLine !== false) {
                $inputLength = strlen($inputDataLine);

                if (!socket_write($this->socket, $inputDataLine, $inputLength)) {
                    throw new Exception('Ошибка при отправке сообщения');
                }

                $response = socket_read($this->socket, $this->maxMessageLength);

                if ($response === false) {
                    throw new Exception("Ошибка при чтении ответа от сервера: " . socket_strerror(socket_last_error()));
                }

                echo "Ответ сервера: " . $response . PHP_EOL;
            }
        }
    }
}
