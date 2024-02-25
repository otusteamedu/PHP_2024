<?php

declare(strict_types=1);

namespace hw5;

use hw5\interfaces\ClientServerInterface;

final class Creator
{
    private const CLIENT = 'client';
    private const SERVER = 'server';

    public function create(string $method): ClientServerInterface
    {
        $log = new ConsoleLog();
        switch ($method) {
            case self::SERVER:
                $file = new File(getenv('SOCKET_NAME'), true);
                $socket = new UnixSocket($file);
                return new Server($socket, $log);
            case self::CLIENT:
            default:
                $file = new File(getenv('SOCKET_NAME'));
                $socket = new UnixSocket($file);
                return new Client($socket, $log);
        }
    }
}
