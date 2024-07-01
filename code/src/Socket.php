<?php

declare(strict_types=1);

namespace Rrazanov\Hw5;

use Exception;

class Socket
{
    public static \Socket $socket;
    public static string $pathSocket;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $config = parse_ini_file('/data/public/config.ini');
        if (!key_exists('socketPath', $config)) {
            throw new Exception('Не указан путь до сокета.', 400);
        }
        self::$pathSocket = $config['socketPath'];
        if (!extension_loaded('sockets')) {
            throw new Exception('Расширение сокетов не загружено.', 400);
        }

        self::$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!self::$socket) {
            throw new Exception('Невозможно создать сокет AF_UNIX.', 400);
        }
    }

    /**
     * @throws Exception
     */
    public function initSocket(): void
    {
        if (file_exists(self::$pathSocket)) {
            unlink(self::$pathSocket);
        }
        if (!socket_bind(self::$socket, self::$pathSocket)) {
            throw new Exception('Невозможно привязаться к ' . self::$pathSocket, 400);
        }
    }

    /**
     * @throws Exception
     */
    public function listingSocket(): void
    {
        if (!socket_listen(self::$socket)) {
            throw new Exception('Невозможно прослушивать входящие соединения на сокете', 400);
        }
    }

    /**
     * @throws Exception
     */
    public function acceptSocket()
    {
        if ($acceptSocket = socket_accept(self::$socket)) {
            return $acceptSocket;
        } else {
            throw new Exception("Ошибка вызова socket_accept(): " . socket_strerror(socket_last_error(self::$socket)) . "\n", 400);
        }
    }

    /**
     * @throws Exception
     */
    public function readSocket(\Socket $socket = null): bool|string
    {
        if ($acceptSocket = socket_read($socket ?? self::$socket, 65536)) {
            return $acceptSocket;
        } else if (socket_last_error($socket ?? self::$socket) == 0) {
            return false;
        } else {
            throw new Exception("Ошибка вызова socket_read(): " . socket_strerror(socket_last_error($socket ?? self::$socket)) . "\n", 400);
        }
    }

    /**
     * @throws Exception
     */
    public function connectSocket(): bool
    {
        if (socket_connect(self::$socket, self::$pathSocket)) {
            return true;
        } else {
            throw new Exception("Ошибка вызова socket_connect(): " . socket_strerror(socket_last_error(self::$socket)) . "\n", 400);
        }
    }

    public function sendMessage(string $msg): int
    {
        if ($bytes = socket_write(self::$socket, $msg, strlen($msg))) {
            return $bytes;
        } else {
            throw new Exception("Ошибка вызова socket_write(): " . socket_strerror(socket_last_error(self::$socket)) . "\n", 400);
        }
    }
}
