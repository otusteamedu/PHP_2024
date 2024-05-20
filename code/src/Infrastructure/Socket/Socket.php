<?php
declare(strict_types=1);

namespace App\Infrastructure\Socket;

use App\Services\Config\Config;

class Socket
{

    protected string $socketPath;
    protected array $socketConst;

    public function __construct(Config $config)
    {
        $this->socketPath = $config->getSocketPath();
        $this->socketConst = $config->getSockConst();
    }

    private function create(): bool|\Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            echo "Не удалось выполнить socket_create(), причина: " . socket_strerror(socket_last_error()).PHP_EOL;
            return false;
        } else echo "Сокет создан.".PHP_EOL;
        return $socket;
    }

    protected function prepareClient(): bool|\Socket
    {
        $socket = $this->create();
        try {
            socket_connect($socket, $this->socketPath);
        } catch (\Exception $e) {
            echo "Не удалось выполнить socket_connect().".PHP_EOL."Причина: " . socket_strerror(socket_last_error($socket)) .PHP_EOL;
            return false;
        }
        return $socket;
    }

    protected function prepareServer(): bool|\Socket
    {
        $socket = $this->bind();
        if (socket_listen($socket) === false) echo "Не удалось выполнить socket_listen(), причина: " . socket_strerror(socket_last_error($socket)) . PHP_EOL;
        return $socket;
    }

    private function bind(): bool|\Socket
    {
        $path = $this->socketPath;
        if (file_exists($path)) unlink($path);
        $socket = $this->create();
        socket_bind($socket,$path);
        return $socket;
    }

    protected function accept(\Socket $socket): bool|\Socket
    {
        $accept = socket_accept($socket);
        if ($accept === false) {
            echo "Не удалось выполнить socket_accept(), причина: " . socket_strerror(socket_last_error($socket)).PHP_EOL;
            return false;
        }
        return $accept;
    }

    protected function write(\Socket $socket,$msg): bool
    {
        try {
            socket_write($socket, $msg, strlen($msg));
        } catch (\Exception $exception) {
            echo $exception.PHP_EOL;
            return false;
        }
        return true;
    }

    protected function read(\Socket $socket,$bite = 2048): bool|string
    {
        $socket_read = socket_read($socket,$bite);
        if ($socket_read === false) {
            echo "Не удалось выполнить socket_read(), причина: " .
                socket_strerror(socket_last_error($socket)).PHP_EOL;
            return false;
        }
        return is_string($socket_read)? $socket_read : "Сообщения нет!";
    }

    protected function close(\Socket $socket) {
        socket_close($socket);
    }
}