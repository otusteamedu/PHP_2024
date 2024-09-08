<?php

namespace PenguinAstronaut\App;

use PenguinAstronaut\App\Exceptions\SocketConnectException;
use PenguinAstronaut\App\Exceptions\SocketCreateException;

class SocketClient
{
    const string STOP_WORD = 'exit';
    /**
     * @throws SocketConnectException
     * @throws SocketCreateException
     */
    public function run(): void
    {
        $file = '/sock/appsock.sock';

        while (true) {
            $socket = new UnixSocket($file);
            $socket
                ->create()
                ->connect();

            if (($message = readline('Введите текст: ')) === self::STOP_WORD) {
                break;
            }

            $socket->write($message);
            $response = $socket->read();

            echo $response . PHP_EOL;
        }

        $socket->close();
    }
}
