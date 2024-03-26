<?php
declare(strict_types=1);

namespace App\Services\Socket;

abstract class Socket
{
    # Вынести в config.ini
    const SOCKET_PATH = '/tmp/phpsocket/socket.sock';
    protected $init;
    protected $acceptConn;

    protected function create()
    {
        try {
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            $this->init = $socket;
        } catch (\Exception) {
            echo "Не удалось выполнить socket_create(): " . socket_strerror(socket_last_error());
        }
    }

    protected function bind()
    {
        if (file_exists(self::SOCKET_PATH)) unlink(self::SOCKET_PATH);
        try {
            socket_bind($this->init,self::SOCKET_PATH);
        } catch (\Exception) {
            echo "Не удалось выполнить socket_bind(): " . socket_strerror(socket_last_error());
        }
    }

    protected function listen()
    {
        try {
            socket_listen($this->init);
        } catch (\Exception) {
            echo "Не удалось выполнить socket_listen(), причина: " . socket_strerror(socket_last_error($this->init)) . PHP_EOL;
        }
    }

    protected function accept()
    {
        try {
            $this->acceptConn = socket_accept($this->init);

        } catch (\Exception) {
            echo "Не удалось выполнить socket_accept(), причина: ".socket_strerror(socket_last_error($this->acceptConn)).PHP_EOL;
        }
    }

    protected function write(string $msg): bool
    {
        $AF_UNIX = AF_UNIX;
        if (!socket_getsockname($this->acceptConn, $AF_UNIX)) return false;
        $msg = trim($msg);
        var_dump($this->acceptConn);
        if (false === socket_write($this->acceptConn, $msg, strlen($msg))) {
            echo "Не удалось выполнить socket_write(), причина: ".socket_strerror(socket_last_error($this->acceptConn)).PHP_EOL;
            return false;
        }
        return true;
    }

    protected function read() {
        if (!$this->acceptConn) return false;
        $str = socket_read($this->acceptConn,2048);
        if ($str === false) echo "Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($this->acceptConn)) . PHP_EOL;
        return $str;
    }

    protected function closeAcceptedCon() {
        try {
            socket_close($this->acceptConn);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    protected function close() {
        try {
            socket_close($this->init);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
}