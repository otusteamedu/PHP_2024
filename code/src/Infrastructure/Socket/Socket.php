<?php
declare(strict_types=1);

namespace App\Infrastructure\Socket;

use App\Domain\TransportInterface\TransportInterface;
use App\Infrastructure\Config\Config;

class Socket implements TransportInterface
{

    protected ?string $socketPath;
    protected ?array $socketConst;
    private \Socket $socket;
    private ?\Socket $socketAccepted = null;

    public function __construct(Config $config)
    {
        $this->socketPath = $config->getSocketPath();
        $this->socketConst = $config->getSockConst();
    }

    private function create()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            echo "Не удалось выполнить socket_create(), причина: " . socket_strerror(socket_last_error()).PHP_EOL;

        } else echo "Сокет создан.".PHP_EOL;
        $this->socket = $socket;
    }

    public function prepareClient()
    {
        $this->create();
        try {
            socket_connect($this->socket, $this->socketPath);
        } catch (\Exception $e) {
            echo "Не удалось выполнить socket_connect().".PHP_EOL."Причина: " . socket_strerror(socket_last_error($this->socket)) .PHP_EOL;
        }
    }

    public function prepareServer()
    {
        $this->bind();
        if (socket_listen($this->socket) === false) echo "Не удалось выполнить socket_listen(), причина: " . socket_strerror(socket_last_error($this->socket)) . PHP_EOL;
    }

    private function bind()
    {
        $path = $this->socketPath;
        if (file_exists($path)) unlink($path);
        $this->create();
        socket_bind($this->socket,$path);
    }

    public function accept(): bool
    {
        $socket = $this->socket;
        try {
            $accept = socket_accept($socket);
        } catch (\Exception $e) {
                echo "Не удалось выполнить socket_accept(), причина: " . socket_strerror(socket_last_error($socket)).PHP_EOL;
        return false;
        }
        $this->socketAccepted = $accept;
        return true;
    }

    public function write($msg): bool
    {
        $socket = $this->socketAccepted?? $this->socket;
        try {
            socket_write($socket, $msg, strlen($msg));
        } catch (\Exception $exception) {
            echo $exception.PHP_EOL;
            return false;
        }
        return true;
    }

    public function read($bite = 2048): bool|string
    {
        $socket = $this->socketAccepted?? $this->socket;
        $socket_read = socket_read($socket,$bite);
        if ($socket_read === false) {
            echo "Не удалось выполнить socket_read(), причина: " .
                socket_strerror(socket_last_error($socket)).PHP_EOL;
            return false;
        }
        return is_string($socket_read)? $socket_read : "Сообщения нет!";
    }

    public function close() {
        $socket = $this->socketAccepted?? $this->socket;
        socket_close($socket);
    }

    /**
     * @return string
     */
    public function getExitKey(): string
    {
        return $this->socketConst['MSG_EXIT'];
    }

}