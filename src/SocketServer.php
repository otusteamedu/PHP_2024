<?php

namespace PenguinAstronaut\App;

use Exception;
use PenguinAstronaut\App\Exceptions\SocketAcceptException;
use PenguinAstronaut\App\Exceptions\SocketBindException;
use PenguinAstronaut\App\Exceptions\SocketCreateException;
use PenguinAstronaut\App\Exceptions\SocketListenException;

class SocketServer
{
    /**
     * @throws SocketCreateException
     * @throws SocketBindException
     * @throws SocketListenException
     */
    public function run(): void
    {
        $file = '/sock/appsock.sock';

        $socket = new UnixSocket($file);
        $socket
            ->clearFile()
            ->create()
            ->bind()
            ->listen();

        do {
            try {
                $socketAccept = $socket->accept();
                if (!$message = $socketAccept->read()) {
                    continue;
                }
                $talkback = 'Server: Вы сказали ' . $message . PHP_EOL;
                $socketAccept
                    ->write($talkback);
            } catch (Exception $exception) {
                echo $exception->getMessage() . PHP_EOL;
                break;
            }
            $socketAccept->close();
        } while (true);
        $socket->close();
    }
}
